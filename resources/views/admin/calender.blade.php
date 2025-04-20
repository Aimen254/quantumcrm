@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-xl-3 col-xxl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-intro-title">Calendar</h4>

                <div class="">
                    <div id="external-events" class="my-3">
                        <p>Drag and drop your event or click in the calendar</p>
                    
                    </div>
                    <!-- checkbox -->
                    <div class="checkbox form-check checkbox-event custom-checkbox pt-3 pb-5">
                        <input type="checkbox" class="form-check-input" id="drop-remove">
                        <label class="form-check-label" for="drop-remove">Remove After Drop</label>
                    </div>
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-category" class="btn btn-primary btn-event w-100">
                        <span class="align-middle"><i class="ti-plus me-2"></i></span> Create New
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-xxl-8">
        <div class="card">
            <div class="card-body">
                <div id="calendar" class="app-fullcalendar"></div>
            </div>
        </div>
    </div>
    <!-- BEGIN MODAL -->
    <div class="modal fade none-border" id="event-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Add New Event</strong></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success save-event waves-effect waves-light">Create
                        event</button>

                    <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-bs-toggle="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add Category -->
    <div class="modal fade none-border" id="add-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Add a category</strong></h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label form-label">Category Name</label>
                                <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label form-label">Choose Category Color</label>
                                <select class="form-control form-white default-select" data-placeholder="Choose a color..." name="category-color">
                                    <option value="success">Success</option>
                                    <option value="danger">Danger</option>
                                    <option value="info">Info</option>
                                    <option value="pink">Pink</option>
                                    <option value="primary">Primary</option>
                                    <option value="warning">Warning</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light save-category" data-bs-toggle="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection