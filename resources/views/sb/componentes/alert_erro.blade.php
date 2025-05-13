<div id="alerta-erro" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>
        <ul>
           @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
           @endforeach
        </ul>
    </strong> 
    <button type="button" id="btn-alerta" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<script>
    setTimeout(() => {
         //$('#btn-alerta').trigger('click')
         $("#alerta-erro").fadeOut( 1000 );
    }, "5000")      
</script>