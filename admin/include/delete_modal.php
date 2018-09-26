<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <button type="button" class="close m-0 p-0" data-dismiss="modal">&times;</button>
        <h4 class="modal-title ml-2">Please Confirm</h4>
      </div>
      <div class="modal-body">
        <p class="lead text-center">Are you sure you want to delete this post?</p>
      </div>
      <div class="modal-footer">
          <form action="" method="post">
              <input type="hidden" class='modal_delete_link' name="delete_item" value=''>
              <input name="delete" class="btn btn-danger modal-link" type="submit" value="Delete">
          </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
