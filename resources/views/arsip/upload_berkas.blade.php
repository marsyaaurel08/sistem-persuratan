@extends('layout.app')

@section('title', 'Upload to Archive')

@section('content')
    <div class="main-content">
        <div class="page-header d-flex align-items-center justify-content-between mb-4 pb-2 rounded">
            <div class="page-header-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url()->previous() }}"
                                class="d-flex align-items-center text-dark fw-bold decoration-none">
                                <div class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 35px; height: 35px; border: 1px solid #eee;">
                                    <i class="feather-arrow-left text-primary"></i>
                                </div>
                                <span style="font-size: large; letter-spacing: -0.5px;">Upload Berkas</span>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="card stretch stretch-full shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="border-dashed border-2 p-5 text-center rounded-4 position-relative mb-4"
                                style="border-style: dashed; border-color: #d1d5db; background-color: #f8fafc; cursor: pointer;">
                                <input type="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="cursor: pointer;" multiple name="files[]">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle mb-3">
                                        <i class="feather-upload-cloud fs-1 text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Select files to upload or drag and drop here</h5>
                                    <p class="text-muted small">Supported formats: PDF, DOCX, JPG, TIFF (Max 50MB per file)
                                    </p>
                                    <button type="button" class="btn btn-primary px-4 fw-bold">Browse Files</button>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-3">Files to Upload (3)</h6>
                            <div class="list-group gap-2">
                                <div class="list-group-item rounded-3 border p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="feather-file-text text-primary fs-4 me-3"></i>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold text-dark small">Annual_Budget_Report_2023.pdf</span>
                                                <i class="feather-x text-muted cursor-pointer"></i>
                                            </div>
                                            <span class="text-muted" style="font-size: 11px;">4.2 MB • Uploading...</span>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar" role="progressbar" style="width: 70%"></div>
                                    </div>
                                </div>

                                <div class="list-group-item rounded-3 border p-3 border-success bg-light-success">
                                    <div class="d-flex align-items-center">
                                        <i class="feather-image text-success fs-4 me-3"></i>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold text-dark small">Signed_Contract_A102.jpg</span>
                                                <div>
                                                    <i class="feather-check-circle text-success me-2"></i>
                                                    <i class="feather-trash-2 text-muted cursor-pointer"></i>
                                                </div>
                                            </div>
                                            <span class="text-muted" style="font-size: 11px;">1.8 MB • Ready to
                                                archive</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Archive Details</h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Letter Subject</label>
                                <input type="text" class="form-control bg-light border-0 py-2"
                                    placeholder="Enter letter subject or title">
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Reference Number</label>
                                    <input type="text" class="form-control bg-light border-0 py-2" value="EO/2023/102">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Correspondence Date</label>
                                    <input type="date" class="form-control bg-light border-0 py-2">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Category</label>
                                <select class="form-select bg-light border-0 py-2">
                                    <option selected disabled>Select a category</option>
                                    <option>Financial</option>
                                    <option>Human Resources</option>
                                    <option>Legal</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small">Tagging</label>
                                <div
                                    class="form-control bg-light border-0 d-flex flex-wrap gap-1 align-items-center min-vh-auto py-2">
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary d-flex align-items-center gap-1">Urgent
                                        <i class="feather-x" style="font-size: 10px;"></i></span>
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary d-flex align-items-center gap-1">Finance
                                        <i class="feather-x" style="font-size: 10px;"></i></span>
                                    <input type="text" class="border-0 bg-transparent small ms-1" placeholder="Add tags..."
                                        style="outline: none; width: 80px;">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-2">
                                <i class="feather-archive me-2"></i> Submit to Archive
                            </button>
                            <button type="reset" class="btn btn-light w-100 py-2 fw-bold text-muted">
                                Clear All
                            </button>

                            <div class="mt-4 p-3 bg-light-primary rounded-3 border-start border-primary border-4">
                                <div class="d-flex">
                                    <i class="feather-info text-primary me-2"></i>
                                    <p class="mb-0 small text-muted">
                                        <strong>Note:</strong> Archived files are encrypted and stored in the primary data
                                        center. Access to these files will be restricted based on the department security
                                        policy.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection