<template>
    <div>
        <ul class="pagination">
            <li v-if="headings.prev_page_url">
                <a href="#" aria-label="Previous" @click="loadNewHeadings(headings.prev_page_url)">
                    <span aria-hidden="true">&laquo; Previous </span>
                </a>
            </li>
            <li v-if="headings.next_page_url">
                <a href="#" aria-label="Next" @click="loadNewHeadings(headings.next_page_url)">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        </ul>
        <ul class="list-group">
            <router-link v-for="heading in headings.data" tag="li" :to="headingUrl(heading.id)" class="list-group-item" exact>
                <a>
                    <span>{{ heading.title }}</span>
                </a>
            </router-link>
        </ul>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                headings: {},
            }
        },
        methods: {
            loadHeadings(url) {
                axios.get(url)
                    .then(response => this.headings = response.data);
            },
            loadNewHeadings(url) {
                this.loadHeadings(url);
            },
            headingUrl(id) {
                return `/headings/${id}`;
            }
        },
        created() {
            this.loadHeadings('/api/headings');
        }
    }
</script>