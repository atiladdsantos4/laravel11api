<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
  <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
    <div class="toast-header">
      <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;
      <strong class="mr-auto">Mensagem</strong>
      <!-- <small>11 mins ago</small> -->
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body {{ $bg }}" style="color:white;">
      {{ $mes }}
    </div>
  </div>
</div>
