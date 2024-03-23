<x-app-layout>

    @slot('content')
        <div class="container-fluid py-2">
            <div class="row">
                <div class="card col-12 p-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                    href="{{ route('dashboard') }}">dashboard</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">user</li>
                        </ol>
                    </nav>
                    <div class="col-12 mt-3">
                        <button type="button" id="buttonCreate" class="btn btn-info add-button" data-bs-toggle="modal"
                            data-bs-target="#modal">
                            Tambah User
                        </button>
                    </div>
                    <form method="GET" action="{{ route('user') }}" id="searchForm">
                        <div class="input-group input-group-dynamic mb-4">
                            <input type="text" class="form-control" name="search"
                                placeholder="Cari berdasarkan nama user ...">
                            <button type="submit" class="btn btn-outline-secondary mx-1 rounded btn-sm">
                                <span class="material-icons">search</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary mx-1 rounded btn-sm" id="clearButton">
                                <span class="material-icons">clear</span>
                            </button>
                        </div>
                    </form>
                    <div class="table-responsive p-0">
                        <table class="table table-striped" style="width:100%" id="userTable">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" style="width:5%">No</th>
                                    <th scope="col" style="width:30%">Nama</th>
                                    <th scope="col" style="width:30%">Email</th>
                                    <th scope="col" style="width:30%">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="text-center">
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <a href="#" class="badge text-white text-bg-warning edit-link"
                                                data-bs-toggle="modal" data-bs-target="#modal"
                                                data-id="{{ $user->id }}">
                                                Edit
                                            </a> |
                                            <a href="#" class="badge text-white text-bg-danger delete-link"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="{{ $user->id }}">
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
                                <li class="page-item  {{ $i === $originalData->currentPage() ? 'active' : '' }}">
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

        {{-- create user  --}}
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    @method('POST')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalLabel">Label Modal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control border px-2" id="name" name="name"
                                    required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control border px-2" id="email" name="email"
                                    required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control border px-2" id="password" name="password"
                                    required>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select px-2 border" aria-label="Default select example"
                                    name="role" id="role" required>
                                    <option selected>Pilih Role</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                </form>
            </div>
        </div>


        {{-- delete user  --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModal2Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_user" id="deleteIdInput">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModal2Label">Hapus User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Hapus User ?
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
            var formAction = "{{ route('user.destroy', ['id' => ':id']) }}";
            formAction = formAction.replace(':id', id);

            $('#deleteModal form').attr('action', formAction);
        });


        $('.edit-link').click(function(e) {
            var modalLabel = $("#modalLabel");
            modalLabel.text("Edit User");

            let id = $(this).data('id');
            var formAction = "{{ route('user.update', ['id' => ':id']) }}";
            var formAction = formAction.replace(':id', id);
            var form = $('#modal form')
            form.attr('action', formAction);
            form.find('input[name="_method"]').val('PUT');

            var password = $("#password");
            password.removeAttr("required");

            var url = "{{ route('user.edit', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    let user = response.user
                    $('#name').val(user.name);
                    $('#email').val(user.email);

                    var roles = response.roleDropdown;
                    var el = $("#role");
                    el.empty();
                    $.each(roles, function(i, role) {
                        el.append($("<option></option>").attr("value", role.value)
                            .text(role.label));
                    });
                    $('#role').val(user.role);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $('#buttonCreate').click(function(e) {
            var modalLabel = $("#modalLabel");
            modalLabel.text("Tambah User");

            let id = $(this).data('id');
            var formAction = "{{ route('user.store') }}";
            $('#modal form').attr('action', formAction);

            var url = "{{ route('user.create') }}"
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var roles = response.roleDropdown;
                    var el = $("#role");
                    el.empty();
                    $.each(roles, function(i, role) {
                        el.append($("<option></option>").attr("value", role.value)
                            .text(role.label));
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    });
</script>
