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
           e.preventDefault();
           const id = $(this).data('id');
           const url = `/cms/admin/posts.php?delete=${id}`;
           $('.modal-link').attr('href', url);
           $('#myModal').modal('show');
       });

       // ************** PUSHER INIT *****************//
       const pusher = new Pusher('d8339920520e053b9885', {
           cluster: 'eu',
           encrypted: true
       });

       const channel = pusher.subscribe('notifications');
       channel.bind('new_user', function(data) {
           const info = data.message;
           toastr.success(`${info} has just registered.`);
       });

   });