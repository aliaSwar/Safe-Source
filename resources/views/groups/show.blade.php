<x-layouts.app>

    <slot name="styles">
        <link rel="stylesheet" href="{{ asset('assets\loading.css') }}">
    </slot>

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row">
                <div class="col-14">
                    <div class="card mb-4">
                        <h5 class="card-header">{{ $category->category }}</h5>
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

                            </form>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="container">
                <input class="form-control mb-4" id="tableSearch" type="text" placeholder="بحث..">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="table-success ">اسم العائلة</th>
                            <th class="table-success ">رقم الاستمارة</th>
                            <th class="table-success ">رقم الهاتف</th>
                            <th class="table-success ">الفئة </th>
                            <th class="table-success ">التفاصيل </th>
                        </tr>
                    </thead>
                    @foreach ($category->entries as $entry)
                        <tr>
                            <td>{{ $entry->id }}</td>
                            <td>{{ $entry->family_name }}</td>
                            <td>{{ $entry->phone_num }}</td>
                            <td><span class="badge bg-label-success me-1">{{ $entry->category->category }}</span>
                            </td>
                            <td><span class="badge bg-label-info me-1">{{ $entry->status->status }}</span>
                            </td>
                            <td><span class="badge bg-label-danger me-1">{{ $entry->financial->type }}</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ route('entries.show', $entry) }} detail"><i
                                                class="bx bx bxs-detail"></i> عرض التفاصيل</a>
                                        <a class="dropdown-item" href="{{ route('entries.edit', $entry) }}"><i
                                                class="bx bx-edit-alt me-1"></i> تعديل</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </section>
</x-layouts.app>
