<template>
  <div>
      <div v-if="viewing.length">
          <hr/>
          <p>Other users currently viewing this thread:</p>
          <ul >
              <li v-for="user in viewing">
                  <a :href="'/profiles/' + user.name">@{{ user.name }}</a> 
              </li>
          </ul>
      </div>
  </div>
</template>

<script>

export default {

    data() {
        return {
            users: []
        }
    },

    computed: {
        viewing () {
            let exclude = ['guest']

            if (window.App.signedIn) {
                exclude.push(window.App.user.username)
            }

            return this.users.filter(user => !exclude.includes(user.name));
        }
    },

    created() {
        if (typeof window.Echo !== 'undefined') {
            window.Echo.join(`forum.${window.channel}`)
                .here((users) => {
                    this.users = users;
                })
                .joining((user) => {
                    this.users.push(user);
                })
                .leaving((user) => {
                    this.users.splice(this.users.indexOf(user), 1)
                });        
        }
    }
};
</script>