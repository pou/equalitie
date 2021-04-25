import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Dashboard extends Component {
    constructor() {
        super();
        this.state = {
            documents: [],
        }

        this.addDocument = this.addDocument.bind(this);
    }
    componentDidMount() {
        fetch('/api/documents')
            .then(response => {
                return response.json();
            })
            .then(documents => {
                documents = documents.data;
                this.setState({ documents });
            });
    }

    renderDocuments() {
        return this.state.documents.map((document) => (
            <tr key={document.id}>
                <td className="px-6 py-4 whitespace-nowrap">
                    <div className="text-sm font-medium text-gray-900">{document.author}</div>
                </td>
                <td className="px-6 py-4 whitespace-nowrap">
                    <div className="text-sm text-gray-900">{document.title}</div>
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href={document.url} className="text-indigo-600 hover:text-indigo-900">
                        Edit
                    </a>
                </td>
            </tr>
        ))
    }

    addDocument() {
        console.warn(this);
        fetch('/api/documents', {method: 'PUT'})
            .then(response => response.json())
            .then(function(documents) {
                documents = documents.data;
                this.setState({ documents });
            }.bind(this));
    }

    render() {
        return (
            <div className="flex flex-col">
                <div className="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div className="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div className="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Author
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Title
                                    </th>
                                    <th scope="col" className="relative px-6 py-3">
                                        <span className="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                { this.renderDocuments() }
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div className="px-4 py-3 text-right sm:px-6">
                    <button onClick={this.addDocument}
                            className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add document
                    </button>
                </div>
            </div>
        );
    }
}

export default Dashboard;
