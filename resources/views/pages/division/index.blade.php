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
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">divisi</li>
                        </ol>
                    </nav>
                    <div class="col-12 mt-3">
                        <button type="button" class="btn btn-info add-button" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            Tambah Divisi
                        </button>
                    </div>
                    <form method="GET" action="{{ route('division') }}" id="searchForm">
                        <div class="input-group input-group-dynamic mb-4">
                            <input type="text" class="form-control" name="search"
                                placeholder="Cari berdasarkan nama divisi ...">
                            <button type="submit" class="btn btn-outline-secondary mx-1 rounded btn-sm">
                                <span class="material-icons">search</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary mx-1 rounded btn-sm" id="clearButton">
                                <span class="material-icons">clear</span>
                            </button>
                        </div>
                    </form>
                    <div class="table-responsive p-0">
                        <table class="table table-striped" style="width:100%" id="divisiTable">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" style="width:5%">No</th>
                                    <th scope="col" style="width:30%">Nama</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($divisions as $division)
                                    <tr class="text-center">
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $division->name }}</td>
                                        <td>
                                            <a href="#" class="badge text-white text-bg-warning edit-link"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $division->id }}">
                                                Edit
                                            </a> |
                                            <a href="#" class="badge text-white text-bg-danger delete-link"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="{{ $division->id }}">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div>{!! $originalData->links() !!}</div> --}}

                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($originalData->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="javascript:;" aria-label="Previous">
                                        <span class="material-icons">keyboard_arrow_left</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $originalData->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <span class="material-icons">keyboard_arrow_left</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @for ($i = 1; $i <= $originalData->lastPage(); $i++)
                                <li class="page-item {{ $i === $originalData->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $originalData->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($originalData->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $originalData->nextPageUrl() }}" aria-label="Next">
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

        {{-- create division  --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ route('division.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Divisi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control border px-2" id="" name="name"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                </form>
            </div>
        </div>

        {{-- edit division  --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Edit Divisi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Nama Divisi</label>
                                <input type="text" class="form-control border px-2" id="name" name="name">
                                <input type="hidden" class="form-control border px-2" id="id_division"
                                    name="id_division">
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

        {{-- delete division  --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModal2Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_division" id="deleteIdInput">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModal2Label">Hapus Divisi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Hapus Divisi ?
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
        $("[type='number']").keypress(function(evt) {
            evt.preventDefault();
        });

        $('.delete-link').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#deleteIdInput').val(id);
            var formAction = "{{ route('division.destroy', ['id' => ':id']) }}";
            formAction = formAction.replace(':id', id);

            $('#deleteModal form').attr('action', formAction);
        });


        $('.edit-link').click(function(e) {
            let id = $(this).data('id');
            var formAction = "{{ route('division.update', ['id' => ':id']) }}";
            var formAction = formAction.replace(':id', id);
            $('#editModal form').attr('action', formAction);

            var url = "{{ route('division.edit', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    let division = response.division
                    $('#id_division').val(division.id);
                    $('#name').val(division.name);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    });
</script>
