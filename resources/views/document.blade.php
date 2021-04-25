@extends('layout')

@section('body')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <form action="{{ route('document.update', ['document' => $document->id]) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Document #{{ $document->id }}
                </h3>
            </div>
            @if ($message = Session::get('success'))
                <div class="bg-indigo-600">
                    <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between flex-wrap">
                            <div class="w-0 flex-1 flex items-center">
                                <p class="ml-3 font-medium text-white truncate">
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(count($errors) > 0)
                <div class="bg-red-200">
                    <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between flex-wrap">
                            <div class="w-0 flex-1 flex items-center">
                                <ul class="ml-3 font-medium text-black truncate">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Author name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="author" class="block text-sm font-medium text-gray-700">Author
                                    Author</label>
                                <input type="text" name="author" id="author"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       value="{{ $document->author }}">
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Title
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                       value="{{ $document->title }}">
                            </div>
                        </dd>
                    </div>
                    @if(!$document->files->isEmpty())
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Attached files
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    @foreach($document->files as $file)
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <div href="#" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                         fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                              d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            {{ 'document-' . $file->id . '.pdf (' . $file->created_at . ')' }}
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            @if(!empty($file->params))
                                                            <ul>
                                                                @if(!empty($file->params['author']))
                                                                <li>Author: {{ $file->params['author'] }}</li>
                                                                @endif
                                                                @if(!empty($file->params['title']))
                                                                    <li>Title: {{ $file->params['title'] }}</li>
                                                                @endif
                                                            </ul>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a href="{{ $file->url }}"
                                                   class="font-medium text-indigo-600 hover:text-indigo-500">
                                                    Download
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </dd>
                        </div>
                    @endif

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                     viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file-upload"
                                           class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span id="file-upload-filename">Upload a file (PDF up to 10MB)</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only"
                                               accept="application/pdf">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </dl>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        var input = document.getElementById('file-upload');

        input.addEventListener('change', () => {
            let infoArea = document.getElementById('file-upload-filename');
            let source = event.srcElement;
            let fileName = source.files[0].name;

            infoArea.textContent = 'Selected file name: ' + fileName;
        });
    </script>
@endsection
