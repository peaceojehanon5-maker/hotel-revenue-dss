let app = new Vue({
    el: "#app",
    data: {
    },
    methods:
    {
        deleteUser (e) {
            var id = e.target.dataset['id'];
            axios.get('core/control.php', {
            params: {
              userId:  id,
            }
          })
          .then(response => {
            alert('USER DELETED!')
            })
          .catch(function (error) {
            alert(error);
    });
        }
    },
    
})

