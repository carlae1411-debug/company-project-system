@extends('layouts.app')

@section('title', 'Archive History')

@section('page-title', 'Archive History')

@section('content')

<div class="archive-history-page">

    {{-- Page Header --}}
    <div class="archive-history-header">

        <div class="archive-history-heading">

            <div class="archive-history-heading-icon">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>

            <div>
                <h2>Archive History</h2>

                <p>
                    Complete history of projects archived and restored.
                </p>
            </div>

        </div>

        <a
            href="{{ route('archive.index') }}"
            class="archive-history-back"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back to Archive
        </a>

    </div>


    {{-- Summary --}}
    <div class="archive-history-summary">

        <div class="archive-history-summary-card">

            <div class="archive-history-summary-icon">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>

            <div>
                <span>Total History</span>
                <strong>{{ $histories->count() }}</strong>
            </div>

        </div>

        <div class="archive-history-summary-card">

            <div class="archive-history-summary-icon archive-icon">
                <i class="fa-solid fa-box-archive"></i>
            </div>

            <div>
                <span>Archived</span>
                <strong>
                    {{ $histories->where('action', 'archived')->count() }}
                </strong>
            </div>

        </div>

        <div class="archive-history-summary-card">

            <div class="archive-history-summary-icon restore-icon">
                <i class="fa-solid fa-rotate-left"></i>
            </div>

            <div>
                <span>Restored</span>
                <strong>
                    {{ $histories->where('action', 'restored')->count() }}
                </strong>
            </div>

        </div>

    </div>


    {{-- History Table --}}
    <div class="archive-history-card">

        <div class="archive-history-card-header">

            <div>
                <h3>Activity History</h3>

                <p>
                    Records of all archive and restore activities.
                </p>
            </div>

        </div>


        @if($histories->count())

            <div class="archive-history-table-wrapper">

                <table class="archive-history-table">

                    <thead>

                        <tr>
                            <th>Project</th>
                            <th>Client</th>
                            <th>Action</th>
                            <th>Date & Time</th>
                            <th>Performed By</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($histories as $history)

                            <tr>

                                {{-- Project --}}
                                <td>

                                    <div class="history-project">

                                        <div class="history-project-icon">
                                            <i class="fa-solid fa-folder"></i>
                                        </div>

                                        <div>

                                            <strong>
                                                {{ $history->project_code }}
                                            </strong>

                                            <span>
                                                {{ $history->name }}
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- Client --}}
                                <td>
                                    {{ $history->client ?? '—' }}
                                </td>


                                {{-- Action --}}
                                <td>

                                    @if($history->action === 'archived')

                                        <span class="history-action history-action-archived">

                                            <i class="fa-solid fa-box-archive"></i>

                                            Archived

                                        </span>

                                    @elseif($history->action === 'restored')

                                        <span class="history-action history-action-restored">

                                            <i class="fa-solid fa-rotate-left"></i>

                                            Restored

                                        </span>

                                   

                                    @elseif($history->action === 'permanently_deleted')
                                        <span class="action-badge action-badge-deleted">
                                                                
                                             <i class="fa-solid fa-trash"></i>
                                            Permanently Deleted
                                                                
                                                            
                                    </span>

                                </td>

                                 @endif
                                {{-- Date --}}
                                <td>

                                    @if($history->action_at)

                                        <div class="history-date">

                                            <strong>
                                                {{ $history->action_at->format('M d, Y') }}
                                            </strong>

                                            <span>
                                                {{ $history->action_at->format('h:i A') }}
                                            </span>

                                        </div>

                                    @else

                                        —

                                    @endif

                                </td>


                                {{-- User --}}
                                <td>

                                    <div class="history-user">

                                        <div class="history-user-icon">
                                            <i class="fa-solid fa-user"></i>
                                        </div>

                                        {{ $history->action_by && isset($users[$history->action_by])
                                            ? $users[$history->action_by]->name
                                                    : 'System' }}

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- Empty State --}}

            <div class="archive-history-empty">

                <div class="archive-history-empty-icon">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <h3>No Archive History</h3>

                <p>
                    No archive or restore activity has been recorded yet.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection