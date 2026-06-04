@extends('layouts.admin')

@section('content')

@include('partials.dashboard.stats')

@include('partials.dashboard.chart')

@include('partials.dashboard.tables')

@endsection

@section('scripts')

<script>

const ctx = document.getElementById('inventoryChart');

if (ctx)
{
    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json($months),

            datasets: [

                {
                    label: 'Buku Masuk',
                    data: @json($entryData),
                    backgroundColor: '#1e3a8a'
                },

                {
                    label: 'Buku Keluar',
                    data: @json($saleData),
                    backgroundColor: '#6cf8bb'
                }

            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false
        }

    });
}

</script>

@endsection