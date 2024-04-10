<template>
    <div style="max-width: 1000px">

        <RouterLink :to="{name: 'blog'}"><span style="color: var(--primary)">&lt;</span> Back to blog</RouterLink>
        
        <div class="card mt-2" v-if="post">
            <h2>{{ post.title }}</h2>
            <p>{{ post.body }}</p>
            <div class="tags mt-2" v-if="post.tags.length">
                <RouterLink
                    :to="{ name: 'tag-blog', params: { slug: tag.slug } }"
                    class="tag"
                    :key="tag.id"
                    v-for="tag in post.tags"
                    >#{{ tag.name }}</RouterLink
                >
            </div>
        </div>
    </div>
</template>
<script>
import {ref} from 'vue';
import {fetching} from '../utils';
export default {
	props: ["id"],
	setup(props) {
		const post = ref(null);

		async function getPost() {
			const res = await fetching("get", `posts/${props.id}`);
			if (res.status == 200) {
				post.value = res.data.post;
			}
		}

		getPost();

		return { post };
	},
};
</script>
