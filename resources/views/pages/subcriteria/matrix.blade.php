<x-app-layout>

    @slot('content')
    <div class="container-fluid py-2">

        <div class="row" id="hasil_container">
            <div class="card col-12 p-4 d-flex">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mb-4">Matrix Perbandingan Subkriteria</h4>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#myModal">
                            <i class="fas fa-info-circle"></i>
                        </button>
                        <a type="button" class="btn btn-warning" href="{{ route('subcriteria', ['criteriaId' => $criteria_id]) }}">
                            Kembali
                        </a>
                    </div>
                </div>

                @if ($matrix_valid)
                <div class="mb-2">
                    @if (($is_valid) )
                    <p class="alert alert-success text-white py-2 w-30 text-center" style="font-size: 12px">Nilai Consistensi Ratio dan Consistensi Index valid</p>
                    @else
                    <p class="alert alert-danger text-white py-2 w-30 text-center" style="font-size: 12px">Nilai Consistensi Ratio dan Consistensi Index tidak valid, silahkan input kembali</p>
                    @endif
                </div>
                @endif
                @if (count($subcriterias))
                <form method="post" action="/perhitungan_subkriteria/store">
                    @csrf
                    @method('POST')
                    <div class="table-responsive">
                        <table class="table border w-100">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col" style="width:10%">Kriteria</th>
                                    @foreach ($subcriterias as $topHeader)
                                    <th scope="col">{{$topHeader->name}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subcriterias as $sideHeader)
                                <tr class="text-center">
                                    <td class="fw-bold">{{$sideHeader->name}}</td>
                                    @foreach ($sideHeader->comparisons as $cell)
                                    <td>
                                        <select name="{{$cell->id}}" class="form-select px-4 matrix_select" style="padding: 5px 20px" {{$cell['row_idx'] == $cell['column_idx'] ? 'disabled' : ''}} data-id="{{$cell['row_idx'] . ',' . $cell['column_idx']}}">
                                            <option data-dynamic="true" value="{{$cell['value']}}">{{ number_format($cell->value, 3, ',') }}</option>
                                            @foreach (range(1,9) as $point)
                                            <option value="{{$point}}">{{$point}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                                <tr class="text-center">
                                    <td class="border fw-bold text-center">Jumlah</td>
                                    @foreach ($subcriterias as $subcriteria)
                                    <td class="fw-bold border">{{number_format($subcriteria->comparison_column_sum, 3, ',')}}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                Hitung Nilai
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="criteria_id" id="criteria-id" value="{{$criteria_id}}">
                </form>
                @endif
            </div>
        </div>

        @if ($matrix_valid)
        <div class="row mt-4">
            <div class="card col-12 p-4">
                <h4 class="mb-4">Matrix Nilai Kriteria</h4>
                @if (count($subcriterias))
                <div class="table-responsive">
                    <table class="table border">
                        <thead>
                            <tr class="text-center">
                                <th class="border w-10" scope="col">Kriteria</th>
                                @foreach ($subcriterias as $topHeader)
                                <th class="border" scope="col">{{$topHeader->name}}</th>
                                @endforeach
                                <th class="border w-10" scope="col">Jumlah</th>
                                <th class="border w-10" scope="col">Prioritas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcriterias as $sideHeader)
                            <tr class="text-center">
                                <td class="fw-bold border">{{$sideHeader->name}}</td>
                                @foreach ($sideHeader->comparisons as $cell)
                                <td class="border">
                                    {{number_format($cell->normalization_value, 3, ',')}}
                                </td>
                                @endforeach
                                <td class="border">{{number_format($sideHeader->normalization_row_sum, 3, ',')}}</td>
                                <td class="border">{{number_format($sideHeader->priority, 3, ',')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 my-2 w-70 mx-auto">
                    <p class="p-0 m-0" style="color: #333">Max λ = {{number_format($max_lamda, 3, ',')}}</p>
                    <p class="p-0 m-0" style="color: #333">n = {{count($subcriterias)}}</p>
                    <div class="row">
                        <div class="col-6">
                            <p class="p-0 m-0" style="color: #333">Consistensi Index = (max λ - n) / (n-1)</p>
                            <p class="p-0 m-0" style="color: #333">CI = ({{number_format($max_lamda, 3, ',')}} - {{$count_subcriteria}}) / {{$count_subcriteria-1}}</p>
                            <p class="p-0 m-0" style="color: #333">CI = {{number_format($CI, 3, ',')}}</p>
                        </div>
                        <div class="col-6">
                            <p class="p-0 m-0" style="color: #333">Consistensi Ratio = CI/IR</p>
                            <p class="p-0 m-0" style="color: #333">CR = {{$CI}} / {{$IR}}</p>
                            <p class="p-0 m-0" style="color: #333">CR = {{ $CR }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="myModalLabel">Informasi Nilai AHP</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Skala perbandingan berpasangan dalam AHP:</p>
                    <ul>
                        <li>1: Indikasi sama penting</li>
                        <li>3: Sedikit lebih penting</li>
                        <li>5: Lebih penting</li>
                        <li>7: Sangat penting</li>
                        <li>9: Mutlak penting</li>
                        <li>2, 4, 6, dan 8: Nilai tengah antara dua pernyataan yang berdekatan</li>
                    </ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    @endslot

</x-app-layout>
<script>
    $(document).ready(function() {

        $('.matrix_select').on('change', function(e) {
            var selectedOption = $(this).find('option:selected');
            if (!selectedOption.is(':disabled')) {
                var id = $(this).data('id');
                id = id.split(',');
                var targetElement = $('[data-id="' + id[1] + ',' + id[0] + '"]');
                var optionText = '1' + '/' + selectedOption.val();
                var optionValue = 1 / parseInt(selectedOption.val());

                // Remove previously appended option
                targetElement.find('option[data-dynamic="true"]').remove();
                $(this).find('option[data-dynamic="true"]').remove();
                // Add the new option
                targetElement.append($('<option>', {
                    value: optionValue,
                    text: optionText,
                    selected: true,
                    disabled: true,
                    'data-dynamic': true
                }));
            }
        });

        $('form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission
            $(this).find('select:disabled').prop('disabled', false);
            $(this).find('option:disabled').prop('disabled', false);
            var formData = $(this).serialize(); // Serialize the form data

            var criteriaId = $('#criteria-id').val()
            var url = "{{ route('subcriteria.matrix.store', ['criteriaId' => ':criteria_id']) }}"
            url = url.replace(':criteria_id', criteriaId)
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Handle the response from the server
                    toastr.success('Data berhasil disimpan');

                    setTimeout(() => {
                        window.location.href = response.redirect
                    }, 2000);
                },
                error: function() {
                    // Handle the error if the request fails
                }
            });
        });


    });
</script>