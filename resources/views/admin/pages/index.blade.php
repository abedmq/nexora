@extends('admin.layouts.app')

@section('title', 'الصفحات')
@section('page-title', 'إدارة الصفحات')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>الصفحات</span>
@endsection

@section('content')

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-success-light);color:var(--nx-success);">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-file-alt"></i></div>
                <div class="stat-details"><h3>{{ $pages->count() }}</h3><p>إجمالي الصفحات</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-globe"></i></div>
                <div class="stat-details"><h3>{{ $pages->where('status','published')->count() }}</h3><p>منشورة</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-pen-fancy"></i></div>
                <div class="stat-details"><h3>{{ $pages->where('status','draft')->count() }}</h3><p>مسودة</p></div>
            </div>
        </div>
    </div>

    <div class="nx-card">
        <div class="card-header">
            <h5 class="card-title">جميع الصفحات</h5>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-nx-primary"><i class="fas fa-plus me-1"></i> صفحة جديدة</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table nx-table" id="pagesTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>الصفحة</th>
                            <th>الرابط</th>
                            <th>الأقسام</th>
                            <th>الحالة</th>
                            <th>القائمة</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $page->title }}</div>
                                @if($page->template !== 'default')
                                <small class="text-muted">قالب: {{ $page->template }}</small>
                                @endif
                            </td>
                            <td><code style="font-size:12px;">/page/{{ $page->slug }}</code></td>
                            <td><span class="fw-semibold">{{ $page->sections_count }}</span> قسم</td>
                            <td><span class="nx-badge {{ $page->status_color }}"><i class="fas fa-circle" style="font-size:6px;"></i> {{ $page->status_label }}</span></td>
                            <td>
                                @if($page->show_in_nav)
                                <span class="nx-badge success"><i class="fas fa-check"></i></span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $page->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if($page->status === 'published')
                                    <a href="{{ $page->url }}" target="_blank" class="btn btn-sm btn-nx-secondary" title="معاينة"><i class="fas fa-external-link-alt"></i></a>
                                    @endif
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-nx-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#pagesTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json' },
        pageLength: 10
    });
});
</script>
@endsection
