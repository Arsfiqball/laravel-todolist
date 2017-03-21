<template>
  <div class="panel panel-default">
    <div class="panel-heading"><h5>Things to do:</h5></div>

    <ul class="list-group">
      <li v-for="todo in todos" class="list-group-item">
        <div>
          <h4>
            {{ todo.title }}
          </h4>
          <p>
            by {{ todo.user.name }}
          </p>
        </div>
        <button v-on:click="toggleFinished(todo)" :class="[can('update', todo) ? '' : 'disabled', 'btn', 'btn-default', 'btn-sm']" data-toggle="tooltip" data-placement="bottom" :title="todo.finished ? 'Click to mark as not finished' : 'Click to mark as finished' ">
          <span :class="['glyphicon', todo.finished ? 'glyphicon-ok' : 'glyphicon-time']"></span> {{ todo.finished ? 'Finished' : 'Not finished' }}
        </button>
        <button v-on:click="togglePublic(todo)" :class="[can('update', todo) ? '' : 'disabled', 'btn', 'btn-default', 'btn-sm']" data-toggle="tooltip" data-placement="bottom" :title="todo.privacy == 'public' ? 'Click to make it private' : 'Click to make it public' ">
          <span :class="['glyphicon', todo.privacy == 'public' ? 'glyphicon-globe' : 'glyphicon-lock']"></span> {{ todo.privacy == 'public' ? 'Finished' : 'Not finished' }}
        </button>
        <button v-on:click="remove(todo)" :class="[can('delete', todo) ? '' : 'disabled', 'btn', 'btn-danger', 'btn-sm']" data-toggle="tooltip" data-placement="bottom" title="Click to delete this">
          <span class="glyphicon glyphicon-trash"></span> delete
        </button>
      </li>
    </ul>
    <div v-if="showForm" class="panel-body">
      <form method="post" v-on:submit="submit($event)">
        <div class="input-group">
          <span class="input-group-addon">
            <input type="checkbox" v-model="private"> <span class="glyphicon glyphicon-lock"></span> Private
          </span>
          <input class="form-control" type="text" v-model="title" placeholder="Add new task...">
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      // dummy data
      // todo
      return {
        showForm: true,
        private: false,
        title: '',
        todos: [
          {
            title: "No title",
            finished: true,
            privacy: 'public',
            user: {
              name: 'Iqbal'
            }
          },
          {
            title: "No title 2",
            finished: true,
            privacy: 'private',
            user: {
              name: 'Aditia'
            }
          },
          {
            title: "No title 3",
            finished: false,
            privacy: 'public',
            user: {
              name: 'Safnah'
            }
          },
          {
            title: "No title 4",
            finished: false,
            privacy: 'private',
            user: {
              name: 'Rafifa'
            }
          }
        ]
      }
    },
    methods: {
      can(modify, data) {
        // todo
        return true;
      },
      submit(event) {
        // todo
      },
      remove(data) {
        // todo
      },
      toggleFinished(data) {
        // todo
      },
      togglePublic(data) {
        // todo
      }
    }
  }
</script>
