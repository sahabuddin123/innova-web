@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Workflow</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.workflows.update', $workflow->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $workflow->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ $workflow->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="step">Step Number *</label>
                        <input type="number" name="step" id="step" class="form-control" min="1" value="{{ $workflow->step }}" required>
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon (Font Awesome class)</label>
                        <input type="text" name="icon" id="icon" class="form-control" value="{{ $workflow->icon }}" placeholder="e.g., fa fa-step-forward">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $workflow->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $workflow->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Workflow</button>
                    <a href="{{ route('admin.workflows.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection