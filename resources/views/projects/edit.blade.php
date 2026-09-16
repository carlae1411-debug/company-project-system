@extends('layouts.app')

@section('title', 'Edit Project')

@section('page-title', 'Edit Project')

@section('content')

<div class="project-form-page">

    {{-- Page Header --}}
    <div class="project-form-header">

        <div class="project-form-title">

            <a
                href="{{ route('projects.show', $project) }}"
                class="back-button"
            >
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <div>
                <h2>Edit Project</h2>

                <p>
                    Update project information
                </p>
            </div>

        </div>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="form-alert">

            <div class="form-alert-icon">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>

            <div>

                <strong>Please check the following:</strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    {{-- Edit Form --}}
    <form
        action="{{ route('projects.update', $project) }}"
        method="POST"
        class="project-form"
    >

        @csrf

        @method('PUT')


        <div class="form-table-card">

            {{-- Header --}}
            <div class="form-table-header">

                <div>

                    <h3>Project Information</h3>

                    <p>
                        Update the information below.
                    </p>

                </div>

                <div class="required-note">

                    <span>*</span>
                    Required fields

                </div>

            </div>


            <div class="form-table">


                {{-- Project Code --}}
                <div class="form-row">

                    <div class="form-label">

                        <label for="project_code">

                            Project Code
                            <span>*</span>

                        </label>

                        <small>
                            Unique project identification code
                        </small>

                    </div>


                    <div class="form-field">

                        <div class="input-wrapper">

                            <i class="fa-solid fa-hashtag"></i>

                            <input
                                type="text"
                                id="project_code"
                                name="project_code"
                                value="{{ old('project_code', $project->project_code) }}"
                                placeholder="e.g. PRJ-001"
                                required
                            >

                        </div>


                        @error('project_code')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- Project Name --}}
                <div class="form-row">

                    <div class="form-label">

                        <label for="name">

                            Project Name
                            <span>*</span>

                        </label>

                        <small>
                            Name or title of the project
                        </small>

                    </div>


                    <div class="form-field">

                        <div class="input-wrapper">

                            <i class="fa-solid fa-building"></i>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $project->name) }}"
                                placeholder="Enter project name"
                                required
                            >

                        </div>


                        @error('name')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- Client --}}
                <div class="form-row">

                    <div class="form-label">

                        <label for="client">
                            Client
                        </label>

                        <small>
                            Project owner or client
                        </small>

                    </div>


                    <div class="form-field">

                        <div class="input-wrapper">

                            <i class="fa-solid fa-user"></i>

                            <input
                                type="text"
                                id="client"
                                name="client"
                                value="{{ old('client', $project->client) }}"
                                placeholder="Enter client name"
                            >

                        </div>


                        @error('client')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- Status --}}
                <div class="form-row">

                    <div class="form-label">

                        <label for="status">

                            Project Status
                            <span>*</span>

                        </label>

                        <small>
                            Current project status
                        </small>

                    </div>


                    <div class="form-field">

                        <div class="select-wrapper">

                            <i class="fa-solid fa-chart-simple"></i>

                            <select
                                id="status"
                                name="status"
                                required
                            >

                                <option
                                    value="pending"
                                    {{ old('status', $project->status) === 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="ongoing"
                                    {{ old('status', $project->status) === 'ongoing' ? 'selected' : '' }}
                                >
                                    Ongoing
                                </option>

                                <option
                                    value="completed"
                                    {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}
                                >
                                    Completed
                                </option>

                            </select>

                        </div>


                        @error('status')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- Start Date --}}
                <div class="form-row">

                    <div class="form-label">

                        <label for="start_date">
                            Start Date
                        </label>

                        <small>
                            Project commencement date
                        </small>

                    </div>


                    <div class="form-field">

                        <div class="input-wrapper">

                            <i class="fa-solid fa-calendar"></i>

                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                            >

                        </div>


                        @error('start_date')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- End Date --}}
                <div class="form-row">

                    <div class="form-label">

                        <label for="end_date">
                            End Date
                        </label>

                        <small>
                            Expected completion date
                        </small>

                    </div>


                    <div class="form-field">

                        <div class="input-wrapper">

                            <i class="fa-solid fa-calendar-check"></i>

                            <input
                                type="date"
                                id="end_date"
                                name="end_date"
                                value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                            >

                        </div>


                        @error('end_date')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- Description --}}
                <div class="form-row description-row">

                    <div class="form-label">

                        <label for="description">
                            Description
                        </label>

                        <small>
                            Additional project information
                        </small>

                    </div>


                    <div class="form-field">

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Enter project description..."
                        >{{ old('description', $project->description) }}</textarea>


                        @error('description')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


            </div>

        </div>


        {{-- Actions --}}
        <div class="form-actions">

            <a
                href="{{ route('projects.show', $project) }}"
                class="form-btn form-btn-secondary"
            >
                <i class="fa-solid fa-xmark"></i>
                Cancel
            </a>


            <button
                type="submit"
                class="form-btn form-btn-primary"
            >
                <i class="fa-solid fa-floppy-disk"></i>
                Update Project
            </button>

        </div>


    </form>

</div>

@endsection