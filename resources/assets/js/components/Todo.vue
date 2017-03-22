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
          <button v-on:click="toggleFinished(todos.indexOf(todo), todo)" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" :title="todo.finished ? 'Click to mark as not finished' : 'Click to mark as finished' ">
            <span :class="['glyphicon', todo.finished ? 'glyphicon-ok' : 'glyphicon-time']"></span> {{ todo.finished ? 'Finished' : 'Not finished' }}
          </button>
          <button v-on:click="togglePublic(todos.indexOf(todo), todo)" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" :title="todo.privacy == 'public' ? 'Click to make it private' : 'Click to make it public' ">
            <span :class="['glyphicon', todo.privacy == 'public' ? 'glyphicon-globe' : 'glyphicon-lock']"></span> {{ todo.privacy == 'public' ? 'Public' : 'Private' }}
          </button>
        </template>
        <template v-else>
          <button class="disabled btn btn-default btn-sm">
            <span :class="['glyphicon', todo.finished ? 'glyphicon-ok' : 'glyphicon-time']"></span> {{ todo.finished ? 'Finished' : 'Not finished' }}
          </button>
          <button class="disabled btn btn-default btn-sm">
            <span :class="['glyphicon', todo.privacy == 'public' ? 'glyphicon-globe' : 'glyphicon-lock']"></span> {{ todo.privacy == 'public' ? 'Public' : 'Private' }}
          </button>
        </template>
        <template v-if="can('delete', todo)">
          <button v-on:click="remove(todos.indexOf(todo), todo)" :class="['btn', 'btn-danger', 'btn-sm']" data-toggle="tooltip" data-placement="bottom" title="Click to delete this">
            <span class="glyphicon glyphicon-trash"></span> delete
          </button>
        </template>
      </li>
    </ul>
    <div v-if="showForm" class="panel-body">
      <form method="post" v-on:submit.prevent="submit($event)">
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
        showForm: this.auth ? true : false,
        private: false,
        title: '',
        todos: []
      };

      axios.get(this.auth ? '/api/todo/private' : '/api/todo')
        .then(function(res) {
          if (res.data) {
            data.todos = res.data;
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
        var model = this;

        axios.post('/api/todo', {
          private: this.private,
          title: this.title
        }).then(function(res) {
          if (res.data) {
            model.todos.push(res.data);
            model.private = null;
            model.title = '';
          }
        }).catch(function(err) {
          console.log(err);
        });
      },

      remove(index, data) {
        var model = this;

        console.log('this is fired!');

        axios.post('/api/todo/'+data.id+'/delete')
          .then(function(res) {
            if (res.data) {
              model.todos.splice(index, 1);
            }
          })
          .catch(function(err) {
            console.log(err);
          });
      },

      toggleFinished(index, data) {
        var model = this;

        axios.post('/api/todo/'+data.id+'/update', {
          finished: (!data.finished)
        }).then(function(res) {
          if (res.data) {
            model.todos.splice(index, 1, res.data);
          }
        }).catch(function(err) {
          console.log(err);
        });
      },

      togglePublic(index, data) {
        var model = this;

        axios.post('/api/todo/'+data.id+'/update', {
          privacy: data.privacy == 'public' ? 'private' : 'public'
        }).then(function(res) {
          if (res.data) {
            model.todos.splice(index, 1, res.data);
          }
        }).catch(function(err) {
          console.log(err);
        });
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
