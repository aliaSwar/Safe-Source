<x-layouts.app>


    @if (session()->has('data'))
        <div class="alert alert-success">
            <p>{{ session()->get('data') }}</p>
        </div>
    @endif
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 col-md-6">
                <h5 class="pb-1 mb-4">أنواع المدرجين</h5>
            </div>
            <div class="col-12 col-md-6">
                <a href="{{ route('categories.create') }}" class="btn btn-danger">هل تريد إنشاء نوع جديدة؟</a>
            </div>
        </div>
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-6 col-xl-4">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-header">{{ $category->category }}</div>
                        <div class="card-body">
                            <p class="card-text">
                                جمعيتنا , ❤️ جمعية انعاش الفقير الخيرية تحاول مساعدة المدرج
                                ال{{ $category->category }}
                            </p>
                            <p class="demo-inline-spacing">
                            <form method="post" action="{{ route('categories.destroy', $category) }}">
                                @method('delete')
                                @csrf

                                <button type="submit" class="btn btn-primary me-1">حذف</button>

                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary me-1">

                                    تعديل

                                </a>
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-primary me-1">

                                    عرض

                                </a>
                            </form>

                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

</x-layouts.app>
