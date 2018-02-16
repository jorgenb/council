<template>
  <div>
      <small v-show="users.length" v-html="isTyping"></small>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [] // typing users
    };
  },

  computed: {
    isTyping() {
      if (this.users.length === 1) {
        return `${this.users[0]} is typing a reponse.`;
      }
      if (this.users.length === 2) {
        return `${this.users[0]} and ${this.users[1]} are typing a response.`;
      }
      if (this.users.length === 3) {
        return `${this.users[0]}, ${this.users[1]} and ${this.users[2]} are typing a response.`;
      }
      if (this.users.length === 4) {
        return `${this.users[0]}, ${this.users[1]}, ${this.users[2]} and 1 other are typing a response.`;
      }
      if (this.users.length > 4) {
        return `${this.users[0]}, ${this.users[1]}, ${this.users[2]} and ${this.users.length - 3} others are typing a response.`;
      }
    }
  },

  created() {
    if (typeof window.Echo !== 'undefined') {
      window.Echo.private(`forum.${window.channel}`)
        .listenForWhisper('typing', ({ user }) => {
          this.add(user);
        });
    }
  },

  methods: {
    add(user) {
      if (this.users.indexOf(user.username) == -1) {
        this.users.push(user.username);
      }

      // Simulate that the user has stopped typing
      // after a set amount of time.
      setTimeout(
        () => {
          this.remove(user);
        },
        // # of ms we wait until removing the user from the array.
        3000
      );
    },
    remove(user) {
      this.users.splice(user.username, 1);
    }
  }
};
</script>
