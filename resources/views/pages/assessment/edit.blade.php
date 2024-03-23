<x-app-layout>

    @slot('content')
        <div class="container-fluid py-2">

            <div class="row" id="hasil_container">
                <div class="card col-12 p-4">
                    <div class="row">
                        <div class="col-6">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                            href="{{ route('dashboard') }}">dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark"
                                            href="{{ route('assessment') }}">assessment</a>
                                    </li>
                                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">edit penialain
                                        - {{ $employee->name }}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-6 text-end">
                            <a type="button" class="btn btn-warning" href="{{ route('assessment') }}">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <form id="form" method="post"
                        action="{{ route('assessment.update', ['employeeId' => $employee->id]) }}">
                        @csrf
                        @method('POST')

                        @php
                            $chunks = array_chunk($assessments, 2);
                        @endphp

                        @foreach ($chunks as $chunk)
                            <div class="row">

                                @foreach ($chunk as $assessment)
                                    <div class="card col-md-6 mb-4 p-4">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="2" style="text-transform: uppercase;">
                                                        {{ $assessment->criteria }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($assessment->values as $value)
                                                    <tr class="text-left">
                                                        <td class="fw-bold mx-4"
                                                            style="width:70%; text-transform: capitalize;">
                                                            {{ $value->name }}</td>
                                                        <td style="width:30%">
                                                            <select name="{{ $value->id }}" class="form-select px-4"
                                                                style="padding: 5px 20px; width: 100%;">
                                                                @foreach ($grade_dropdown as $grade)
                                                                    <option value="{{ $grade->value }}"
                                                                        @if ($value->value == $grade->value) selected @endif>
                                                                        {{ $grade->label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach

                            </div>
                        @endforeach

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                Update Nilai
                            </button>
                        </div>
                    </form>
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

        $('#formyee').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission
            $(this).find('select:disabled').prop('disabled', false);
            $(this).find('option:disabled').prop('disabled', false);
            var formData = $(this).serialize(); // Serialize the form data

            var url = "{{ route('criteria.matrix.store') }}"
            $.ajax({
                url: url, // Replace with the actual URL to your controller route
                method: 'POST', // Replace with the appropriate HTTP method
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
