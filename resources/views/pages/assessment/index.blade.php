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
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">penilaian pegawai</li>
                        </ol>
                    </nav>
                    <form method="GET" action="{{ route('assessment') }}" class="mb-3 mt-3" id="searchForm">
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
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" style="width:5%">No</th>
                                    <th scope="col" style="width:20%">NIP</th>
                                    <th scope="col" style="width:30%">Nama</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr class="text-center">
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $employee->ein }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>
                                            <a href="{{ route('assessment.edit', ['employeeId' => $employee->id]) }}"
                                                class="badge text-white text-bg-warning">
                                                Edit Nilai
                                            </a>
                                            <a href="{{ route('assessment.create') }}"
                                                class="badge text-white text-bg-success">
                                                Input Nilai
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="pagination">{!! $employees->links() !!}</div> --}}
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($employees->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="javascript:;" aria-label="Previous">
                                        <span class="material-icons">keyboard_arrow_left</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $employees->previousPageUrl() }}" aria-label="Previous">
                                        <span class="material-icons">keyboard_arrow_left</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @for ($i = 1; $i <= $employees->lastPage(); $i++)
                                <li class="page-item {{ $i === $employees->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $employees->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($employees->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $employees->nextPageUrl() }}" aria-label="Next">
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
</script>
