@extends('layouts.admin')

@section('content')

@include('partials.dashboard.stats')

@include('partials.dashboard.chart')

@include('partials.dashboard.tables')

@endsection

@section('scripts')

<script>

const ctx = document.getElementById('inventoryChart');

if (ctx) {

    new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [
            {
                label: 'Buku Masuk',
                data: [12,18,20,15,22,25],
                backgroundColor: '#1e3a8a'
            },
            {
                label: 'Buku Terjual',
                data: [8,14,16,12,18,20],
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