@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                   <ul id="users"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="module">
   const usersElement=document.getElementById('users')
   window.axios.get('/api/users')
   .then(response)=>{
    const users=response.data;
    users.forEach((user,index)=>{
        const element=document.createElement('li')
        element.setAttribute('id',user.id)
        element.innerText=user.name
        usersElement.appendChild(element)
    })
   }
</script>
@endpush
