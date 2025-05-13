<div class="modal fade" id="generatePwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Geração de Token</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlSelect2">Email</label>
                            <input type="text" class="form-control form-control-user"
                               id="m-email" name="m-email" aria-describedby="emailHelp"
                            placeholder="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlSelect2">Token Gerado</label>
                            <input style="font-size:12px;color:red;" type="text" class="form-control form-control-user"
                               id="id_token" name="id_token" aria-describedby="emailHelp"
                            placeholder="">
                            <div class="invalid-feedback"></div>
                        </div>
                </div>
                <!-- <div class="token" style="color:red;">Token:&nbsp<span id="id_token" ></span></div> -->
                <div class="modal-footer">
                    <form name="form" method="POST" action="{{ $rota }}" novalidate>
                         @csrf
                         <div class="row">
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlSelect2">Senha</label>
                                <div class="input-group mb-3">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text pt" id="basic-addon1" onclick="muda($(this));" ><i class="fa fa-eye-slash" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> 
                         </div>
                         <input type="hidden" id="email" name="email">
                         <button class="btn btn-secondary" type="button" data-dismiss="modal" onclick='$(".modal-backdrop").remove();'>Cancel</button>
                         <button class="btn btn-primary" type="button" onclick="gerar_token();">Gerar Token&nbsp;<i class="fa fa-cog" aria-hidden="true"></i>
                         </button>
                     </form>
                </div>
            </div>
        </div>
    </div>