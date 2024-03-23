<x-app-layout>
    @slot('content')
        <div class="container py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                                href="{{ route('dashboard') }}">dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                                href="{{ route('assessment') }}">assessment</a>
                                        </li>
                                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">input
                                            penilaian</li>
                                    </ol>
                                </nav>
                                <a href="{{ route('assessment') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('assessment.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <h5>Nama Pegawai</h5>
                                    <select class="form-select form-select-sm" id="employee_id" name="employee_id">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @foreach ($criterias as $criteria)
                                    <div class="mb-3">
                                        <h5>{{ $criteria->name }}</h5>
                                        @foreach ($criteria->subcriteria as $subcriteria)
                                            <div class="form-group">
                                                <label>{{ $subcriteria->name }}</label>
                                                <select class="form-select form-select-sm"
                                                    name="criteria[{{ $criteria->id }}][subcriteria][{{ $subcriteria->id }}][value]">
                                                    @foreach ([1 => 'Kurang Baik', 2 => 'Cukup Baik', 3 => 'Baik', 4 => 'Sangat Baik'] as $key => $grade)
                                                        <option value="{{ $key }}">{{ $grade }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endslot
</x-app-layout>
