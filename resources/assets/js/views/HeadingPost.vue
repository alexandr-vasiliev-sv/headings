<template>
    <div>
        <div class="level">
            <h1 class=" flex">{{ heading.title }}</h1>
            <button @click="subscribe" class="btn btn-default">Subscribe</button>
        </div>
        <div>
            <div class="form-group" @keydown="form.errors.clear($event.target.name)">
                <textarea v-model="form.text" class="form-control" cols="5" rows="5"></textarea>
                <span class="help-block"
                      v-if="form.errors.has('text')"
                      v-text="form.errors.get('text')"></span>
            </div>
            <div class="form-group">
                <button class="btn btn-default" @click="sendPost">Send</button>
            </div>
        </div>
        <div v-for="post in posts.data" class="panel">
            <div class="panel-body">
                <h4 class="panel-heading">{{ post.author.name }}</h4>
                {{ post.text }}
            </div>
        </div>
        <div>
            <ul class="pager">
                <li v-if="posts.prev_page_url">
                    <a href="javascript:void()" aria-label="Previous" @click="loadPosts(posts.prev_page_url)">
                        <span aria-hidden="true">&laquo; Previous </span>
                    </a>
                </li>
                <li v-if="posts.next_page_url">
                    <a href="javascript:void()" aria-label="Next" @click="loadPosts(posts.next_page_url)">
                        <span aria-hidden="true">Next &raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    var socket = io('//lv.loc:3000');

    export default {
        data() {
            return {
                id: this.$route.params.id,
                heading: {},
                posts: {},
                form: new Form({
                    text: '',
                }),
                subscriptionForm: new Form({}),
            }
        },
        methods: {
            loadHeading() {
                axios.get(`/api/headings/${this.id}`)
                    .then(response => this.heading = response.data);
            },
            loadPosts(url) {
                axios.get(url)
                    .then(response => this.posts = response.data);
            },
            sendPost() {
                this.form.post(`/api/headings/${this.id}/posts`);
            },
            subscribe() {
                this.subscriptionForm.post(`/api/headings/${this.id}/subscribe`);
            }
        },
        created() {
            this.loadHeading();
            this.loadPosts(`/api/headings/${this.id}/posts`);
        },
        mounted() {
            socket.on('new-posts:heading.' + this.id, function(data) {
                this.posts.data.unshift(data);
                this.posts.data.pop();
            }.bind(this));
        }
    }
</script>
<style>
    .level {
        display: flex;
        align-items: center;
    }

    .flex {
        flex: 1;
    }
</style>