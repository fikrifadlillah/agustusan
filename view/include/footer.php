    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        KARANG TARUNA
      </div>
      <strong>Copyright &copy; 2016 <a href="#">FFST</a>.</strong>
    </footer>
  </div>
</body>
<script type="text/javascript">
  function reposition() {
    var modal = $(this),
    dialog = modal.find('.modal-dialog');
    modal.css('display', 'block');
    dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
  }
  $('.modal').on('show.bs.modal', reposition);
  $(window).on('resize', function() {
    $('.modal:visible').each(reposition);
  });
</script>