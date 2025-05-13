<div class="modal fade" id="excluiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#3393DF;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                        <i class="fa fa-lg fa-exclamation-triangle" aria-hidden="true"></i>
                        &nbsp;
                         Exclusão de Registro
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Deseja realmente excluir o registro?</div>
                <div class="modal-footer">
                     <form name="form" method="POST" action="{{ $rota }}" novalidate>
                         @csrf 
                         <input type="hidden" id="{{ $field_pk }}" name="{{ $field_pk }}">
                         <button class="btn btn-secondary" type="button" data-dismiss="modal" onclick='$(".modal-backdrop").remove();'>Cancel</button>
                         <button class="btn btn-primary" type="submit">Excluir</button>
                     </form>
                </div>
            </div>
        </div>
    </div>