<template>
    <div>
        <ul class="list-reset" v-if="registered.length">
            <li class="pb-3 text-sm" v-for="user in registered">
                <a class="link text-blue" :href="'/profiles/' + user.name">@{{ user.name }}</a> 
            </li>
        </ul>
        <p class="text-2xs text-grey-darkest mb-4" v-if="guests.length">
            There {{ (guests.length > 1) ? 'are':'is' }} {{ guests.length }} {{ (guests.length > 1) ? 'guests':'guest' }} browsing the forum.
        </p>
    </div>
</template>

<script>


export default {

  data() {
        return {
            users: []
        }
    },

  created() {
    if (typeof window.Echo !== 'undefined') {
      window.Echo.join('forum.online')
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
  },

  computed: {
    registered() {
      return this.users.filter(user => user.name != 'guest');
    },
    guests() {
      return this.users.filter(user => user.name == 'guest');
    }
  }
};
</script>
