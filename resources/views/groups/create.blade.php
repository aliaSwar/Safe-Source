<x-layouts.app>


    <div class="content-wrapper">

        <div class="container-xxl flex-grow-1 container-p-y">
            <hr class="my-5" />
            <form action="{{ route('groups.store') }}" method="POST" class="row g-3 needs-validation"
                enctype="multipart/form-data">
                @csrf
                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label"> Add a New Group</label>
                    <input name="name" type="text"
                        class="form-control @error('name') border-light-danger @enderror" id="validationCustom01">
                    @error('name')
                        <div>
                            <p class="help is-danger">{{ $message }}</p>
                        </div>
                    @enderror

                </div>
                <div class="row mt-3">
                    <div class="d-grid gap-2 col-lg-6 mx-auto">
                        <button class="btn btn-secondary btn-lg" type="submit">create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



</x-layouts.app>
