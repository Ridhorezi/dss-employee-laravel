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
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">pegawai</li>
                        </ol>
                    </nav>
                    <div class="col-12 mt-3">
                        <button type="button" id="buttonCreate" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Tambah Pegawai
                        </button>
                    </div>
                    <form method="GET" action="{{ route('employee') }}" id="searchForm">
                        <div class="input-group input-group-dynamic mb-4">
                            <input type="text" class="form-control" name="search"
                                placeholder="Cari berdasarkan nama pegawai ...">
                            <button type="submit" class="btn btn-outline-secondary mx-1 rounded btn-sm">
                                <span class="material-icons">search</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary mx-1 rounded btn-sm" id="clearButton">
                                <span class="material-icons">clear</span>
                            </button>
                        </div>
                    </form>
                    <div class="table-responsive p-0">
                        <table class="table table-striped" style="width:100%" id="employeeTable">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" style="width:5%">No</th>
                                    <th scope="col" style="width:20%">NIP</th>
                                    <th scope="col" style="width:30%">Nama</th>
                                    <th scope="col" style="width:10%">Divisi</th>
                                    <th scope="col" style="width:10%">Penilai</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr class="text-center">
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $employee->ein }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->division }}</td>
                                        <td>{{ $employee->assessor }}</td>
                                        <td>
                                            <a href="#" class="badge text-white text-bg-warning edit-link"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $employee->id }}">
                                                Edit
                                            </a> |
                                            <a href="#" class="badge text-white text-bg-danger delete-link"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal2"
                                                data-id="{{ $employee->id }}">
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

        {{-- create employee  --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ route('employee.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pegawai</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">NIP</label>
                                <input type="text" class="form-control border px-2" id="ein" name="ein"
                                    required minlength="6" maxlength="6" pattern="[0-9]{6}"
                                    placeholder="Format NIP adalah 6 digit angka">
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control border px-2" id="" name="name"
                                    required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Divisi</label>
                                <select class="form-select px-2 border" aria-label="Default select example"
                                    name="division_id" id="divisionCreate" required>
                                    <option selected>Pilih Divisi</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Penilai</label>
                                <select class="form-select px-2 border" aria-label="Default select example"
                                    name="assessor_id" id="assessorCreate" required>
                                    <option selected value="0">Pilih Penilai</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- edit employee  --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" class="form-control border px-2" id="id-edit" name="id">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Edit employee</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">NIP</label>
                                <input type="text" class="form-control border px-2" id="ein-edit" name="ein"
                                    required minlength="6" maxlength="6" pattern="[0-9]{6}"
                                    placeholder="Format NIP adalah 6 digit angka" disabled>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control border px-2" id="name-edit" name="name"
                                    required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Divisi</label>
                                <select class="form-select px-2 border" aria-label="Default select example"
                                    name="division_id" id="division-edit" required>
                                    <option selected>Pilih Divisi</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Penilai</label>
                                <select class="form-select px-2 border" aria-label="Default select example"
                                    name="assessor_id" id="assessor-edit" required>
                                    <option selected>Pilih Penilai</option>
                                </select>
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

        {{-- delete employee  --}}
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_employee" id="deleteIdInput">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModal2Label">Hapus employee</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Hapus employee ?
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
            $('#deleteIdInput').val(id); // Set the value of the hidden input field
            var formAction = "{{ route('employee.destroy', ['id' => ':id']) }}"
            formAction.replace(':id', id)
            $('#exampleModal2 form').attr('action', formAction);
        });

        $('.edit-link').click(function(e) {
            let id = $(this).data('id');
            var formAction = "{{ route('employee.update', ['id' => ':id']) }}"
            formAction = formAction.replace(':id', id);
            console.log(id);
            console.log(formAction);
            $('#editModal form').attr('action', formAction);

            var url = "{{ route('employee.edit', ['id' => ':id']) }}"
            url = url.replace(':id', id);
            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var employee = response.employee

                    // set dropdown divisi
                    var divisions = response.divisionsDropdown
                    var elDivision = $("#division-edit");
                    elDivision.empty();
                    $.each(divisions, function(i, division) {
                        elDivision.append($("<option></option>")
                            .attr("value", division.value).text(division.label));
                    });
                    elDivision.val(employee.division_id)

                    // set dropdown assessor
                    var assessors = response.assessorDropdown
                    var elAssessor = $("#assessor-edit");
                    elAssessor.empty();
                    $.each(assessors, function(i, assessor) {
                        elAssessor.append($("<option></option>")
                            .attr("value", assessor.value).text(assessor.label));
                    });
                    elAssessor.val(employee.assessor_id)

                    console.log(employee);
                    $('#id-edit').val(employee.id)
                    $('#ein-edit').val(employee.ein)
                    $('#name-edit').val(employee.name)
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $('#buttonCreate').click(function(e) {
            var url = "{{ route('employee.create') }}"
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var divisions = response.divisionsDropdown;
                    var assessors = response.assessorDropdown;
                    var el = $("#divisionCreate");
                    el.empty();
                    $.each(divisions, function(i, division) {
                        el.append($("<option></option>").attr("value", division
                            .value).text(division.label));
                    });
                    var el = $("#assessorCreate");
                    el.empty();
                    $.each(assessors, function(i, level) {
                        el.append($("<option></option>").attr("value", level.value)
                            .text(level.label));
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

    });
</script>
