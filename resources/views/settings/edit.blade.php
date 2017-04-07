@extends('settings.create')

@section('page-title')
    eQMS | Edit
@stop

@section('page-scripts')
    <script>
       $(function() {
           var form = $('form[name="user-form"]');
            form.attr({
                action: '/settings/{{ $user->id }}',
                method: 'post'
            });
            form.prepend('{{ csrf_field() }}', '{{ method_field('patch') }}');

           //populate selects
           var selectRole = $('select[name="role"]');
           var admin = '{{ $user->role }}';
           if(admin == 'Admin'){
               selectRole.prepend('<option value="Admin">Admin</option>');
           }
           selectRole.val('{{ $user->role }}');
           selectRole.selectpicker('refresh');
           var selectEmployee = $('select[name="employee-id"]');
           selectEmployee.val('{{ $user->user_id }}');
           selectEmployee.selectpicker('refresh');
           selectEmployee.trigger('change');
       });
    </script>
@stop