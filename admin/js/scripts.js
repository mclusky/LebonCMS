   $(document).ready(() => {
       // Text Editor
       ClassicEditor
           .create(document.querySelector('#body'))
           .catch(error => {
               console.error(error);
           });

       //Select all radio buttons
       $('#selectAllBoxes').on('click', function() {
           if (this.checked) {
               $('.checkboxes').prop('checked', true);
           } else if (!this.checked) {
               $('.checkboxes').prop('checked', false);
           }

       });

       // const divBox = '<div id="load-screen"><div id="loading"></div></div>';
       // $('body').prepend(divBox);
       // $('#load-screen')
       //     .delay(600)
       //     .fadeOut(200, function() {
       //         $(this).remove();
       //     });

       function getOnlineUsers() {
           $.get("functions.php?onlineusers=result", (data) => {
               $('#users-online').text(`Users Online: ${data}`);
           })
       }

       setInterval(() => {
           getOnlineUsers();
       }, 500);

       $('.delete').on('click', function() {
           const id = $(this).data('id');
           const url = `/cms/admin/posts.php?delete=${id}`;
           $('.modal-link').attr('href', url);
           $('#myModal').modal('show');

       });
   });