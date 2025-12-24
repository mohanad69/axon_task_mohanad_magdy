@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold mb-3" style="letter-spacing:1px;">Customer Phone Numbers</h2>
            <p class="text-muted">Browse and filter phone numbers by country and validity.</p>
        </div>
    </div>
    <form method="GET" class="row g-3 align-items-end justify-content-center mb-4 bg-light p-3 rounded shadow-sm">
        <div class="col-md-4 col-12">
            <label for="country" class="form-label">Country</label>
            <select name="country" id="country" class="form-select">
                <option value="">All Countries</option>
                @foreach($countries as $country)
                    <option value="{{ $country['code'] }}" {{ request('country') == $country['code'] ? 'selected' : '' }}>{{ $country['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 col-12">
            <label for="state" class="form-label">State</label>
            <select name="state" id="state" class="form-select">
                <option value="">All States</option>
                <option value="Valid" {{ request('state') == 'Valid' ? 'selected' : '' }}>Valid</option>
                <option value="Not Valid" {{ request('state') == 'Not Valid' ? 'selected' : '' }}>Not Valid</option>
            </select>
        </div>
        <div class="col-md-2 col-12 d-grid">
            <button type="submit" class="btn btn-primary fw-bold">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Country</th>
                    <th>State</th>
                    <th>Country Code</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $item)
                    <tr>
                        <td>{{ $item['country'] }}</td>
                        <td>
                            @if($item['state'] === 'Valid')
                                <span class="badge bg-success">Valid</span>
                            @else
                                <span class="badge bg-danger">Not Valid</span>
                            @endif
                        </td>
                        <td>{{ $item['country_code'] }}</td>
                        <td>{{ $item['phone'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No results found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $customers->withQueryString()->links() }}
    </div>
</div>
@endsection
