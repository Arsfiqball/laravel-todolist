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
        <template v-if="can('update', todo)">
          <button v-on:click="toggleFinished(todo)" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" :title="todo.finished ? 'Click to mark as not finished' : 'Click to mark as finished' ">
            <span :class="['glyphicon', todo.finished ? 'glyphicon-ok' : 'glyphicon-time']"></span> {{ todo.finished ? 'Finished' : 'Not finished' }}
          </button>
          <button v-on:click="togglePublic(todo)" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" :title="todo.privacy == 'public' ? 'Click to make it private' : 'Click to make it public' ">
            <span :class="['glyphicon', todo.privacy == 'public' ? 'glyphicon-globe' : 'glyphicon-lock']"></span> {{ todo.privacy == 'public' ? 'Finished' : 'Not finished' }}
          </button>
        </template>
        <template v-else>
          <button class="disabled btn btn-default btn-sm">
            <span :class="['glyphicon', todo.finished ? 'glyphicon-ok' : 'glyphicon-time']"></span> {{ todo.finished ? 'Finished' : 'Not finished' }}
          </button>
          <button class="disabled btn btn-default btn-sm">
            <span :class="['glyphicon', todo.privacy == 'public' ? 'glyphicon-globe' : 'glyphicon-lock']"></span> {{ todo.privacy == 'public' ? 'Finished' : 'Not finished' }}
          </button>
        </template>
        <template v-if="can('delete', todo)">
          <button v-on:click="remove(todo)" :class="['btn', 'btn-danger', 'btn-sm']" data-toggle="tooltip" data-placement="bottom" title="Click to delete this">
            <span class="glyphicon glyphicon-trash"></span> delete
          </button>
        </template>
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
    props: ['auth'],
    data() {
      var data = {
        showForm: true,
        private: false,
        title: '',
        todos: []
      };

      axios.get('/api/todo')
        .then(function(res) {
          if (res.data && res.data.todos) {
            data.todos = res.data.todos;
          }
        })
        .catch(function(err) {
          console.log(err);
        });

      return data;
    },
    methods: {
      can(modify, data) {
        if (this.auth) {
          switch (modify) {
            case 'update':
              if (this.auth.id == data.user.id) {
                return true;
              }
            break;
            case 'delete':
              if (this.auth.id == data.user.id) {
                return true;
              }
            break;
          }
        }

        return false;
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
    },
    mounted() {
      $('[data-toggle="tooltip"]').tooltip();
    },
    updated() {
      $('[data-toggle="tooltip"]').tooltip();
    }
  }
</script>
