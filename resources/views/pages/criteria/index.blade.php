<x-app-layout>

    @slot('content')
        <div class="container-fluid py-2">
            <div class="row">

                <div class="card col-12 p-4">
                    @include('sweetalert::alert')
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                    href="{{ route('dashboard') }}">dashboard</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">criteria</li>
                        </ol>
                    </nav>
                    <div class="col-12 mt-3">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Tambah Kriteria
                        </button>
                        <a type="button" class="btn btn-success" href="{{ route('criteria.matrix') }}">
                            Matrix Kriteria
                        </a>
                    </div>
                    <form method="GET" action="{{ route('criteria') }}" id="searchForm">
                        <div class="input-group input-group-dynamic mb-4">
                            <input type="text" class="form-control" name="search"
                                placeholder="Cari berdasarkan nama kriteria ...">
                            <button type="submit" class="btn btn-outline-secondary mx-1 rounded btn-sm">
                                <span class="material-icons">search</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary mx-1 rounded btn-sm" id="clearButton">
                                <span class="material-icons">clear</span>
                            </button>
                        </div>
                    </form>
                    <div class="table-responsive p-0">
                        <table class="table table-striped" style="width:100%" id="criteriaTable">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" style="width:5%">No</th>
                                    <th scope="col" style="width:65%">Nama Kriteria</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($criterias as $criteria)
                                    <tr class="text-center">
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $criteria->name }}</td>
                                        <td>
                                            <a href="{{ route('subcriteria', ['criteriaId' => $criteria->id]) }}"
                                                class="badge text-white text-bg-primary">
                                                Sub-kriteria
                                            </a> |
                                            <a href="#" class="badge text-white text-bg-warning edit-link"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal3"
                                                data-id="{{ $criteria->id }}">
                                                Edit
                                            </a> |
                                            <a href="#" class="badge text-white text-bg-danger delete-link"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal2"
                                                data-id="{{ $criteria->id }}">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($criterias->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="javascript:;" aria-label="Previous">
                                        <span class="material-icons">keyboard_arrow_left</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $criterias->previousPageUrl() }}" aria-label="Previous">
                                        <span class="material-icons">keyboard_arrow_left</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @for ($i = 1; $i <= $criterias->lastPage(); $i++)
                                <li class="page-item {{ $i === $criterias->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $criterias->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($criterias->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $criterias->nextPageUrl() }}" aria-label="Next">
                                        <span class="material-icons">keyboard_arrow_right</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link" href="javascript:;" aria-label="Next">
                                        <span class="material-icons">keyboard_arrow_right</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        {{-- create kriteria  --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ route('criteria.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kriteria</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Kriteria</label>
                                <input type="text" class="form-control border px-2" id="" name="name">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                </form>
            </div>
        </div>
        </div>

        {{-- edit kriteria  --}}
        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModal3Label"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModal3Label">Edit kriteria</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Kriteria</label>
                                <input type="text" class="form-control border px-2" id="name-edit" name="name">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- delete kriteria  --}}
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModal2Label">Hapus kriteria</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Hapus kriteria ?
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @endslot

</x-app-layout>

<script>
    $(document).ready(function() {

        // Clear input pencarian
        $('#clearButton').click(function() {
            $('#searchInput').val('');
            $('#searchForm').submit();
        });

        // Submit form pencarian saat menekan tombol enter
        $('#searchInput').keydown(function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                $('#searchForm').submit();
            }
        });
    });


    $(document).ready(function() {
        $('.delete-link').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var formAction = "{{ route('criteria.destroy', ['id' => ':id']) }}";
            formAction = formAction.replace(':id', id);
            $('#exampleModal2 form').attr('action', formAction);
        });

        $('.edit-link').click(function(e) {
            var id = $(this).data('id');

            var url = "{{ route('criteria.edit', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#name-edit').val(response.name);
                },
                error: function(err) {
                    console.log(err);
                }
            });

            var formActionEdit = "{{ route('criteria.update', ['id' => ':id']) }}";
            formActionEdit = formActionEdit.replace(':id', id);
            $('#exampleModal3 form').attr('action', formActionEdit);

        });
    });
</script>
