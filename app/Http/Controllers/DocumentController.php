<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentFile;
use Aws\Result;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class DocumentController extends Controller
{
    public function index(int $id)
    {
        $document = Document::find($id);

        if ($document === null) {
            abort(404);
        }

        return view('document', [
            'document' => $document,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $document = Document::find($id);

        if ($document === null) {
            abort(404);
        }

        $request->validate([
            'author' => 'max:255',
            'title' => 'max:255',
            'file' => 'mimes:pdf|max:10240',
        ]);

        $author = $request->get('author');
        $title = $request->get('title');

        if ($request->file()) {
            $fileHash = $this->hash();

            $content = file_get_contents($request->file('file-upload'));
            $s3 = Storage::disk('remote')->getDriver()->getAdapter()->getClient();

            /** @var Result $response */
            $response = $s3->putObject([
                'Bucket' => 'equalitie',
                'Key' => $fileHash,
                'Body' => $content,
                'ContentMD5' => base64_encode(md5($content, true)),
            ]);

            $response = $response->toArray();
            if (!$response || !array_key_exists('ObjectURL', $response)) {
                return back()->withErrors([
                    'Error on storing file.',
                ]);
            }

            $parser = new Parser();
            try {
                $pdf = $parser->parseContent($content);
                $details = $pdf->getDetails();
            } catch (\Exception $exception) {
                $details = [];
            }

            $fileAuthor = Arr::get($details, 'Author', '');
            $fileTitle = Arr::get($details, 'Title', '');
            // ... other props

            $document->files()->create([
                'hash' => $fileHash,
                'params' => [
                    'author' => $fileAuthor,
                    'title' => $fileTitle,
                ],
            ]);
        }

        $document->author = (empty($document->author) && empty($author) && !empty($fileAuthor))
            ? $fileAuthor
            : $author;

        $document->title = (empty($document->title) && empty($title) && !empty($fileTitle))
            ? $fileTitle
            : $title;

        $document->save();

        return back()->with('success', 'Document has been updated.');
    }

    public function file(Request $request, int $id)
    {
        $file = DocumentFile::find($id);
        if ($file === null) {
            abort(404);
        }

        return response()->streamDownload(function () use ($file) {
            echo file_get_contents(Storage::disk('remote')->temporaryUrl($file->hash, \Carbon\Carbon::now()->addHour()));
        }, "document-$file->id.pdf");
    }

    private function hash(): string
    {
        $day = (time() - 1523181655) / 86400;
        $rand = random_int(0, (1 << 45) - 1);
        $id = ($day << 45) | $rand;

        return base_convert($id, 10, 36);
    }
}
