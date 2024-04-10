<template>
	<section id="blog">
		<section class="card-list">
			<div class="card" v-for="blog in blogs" :key="blog.id">
				<h2>{{ blog.title }}</h2>
				<p>{{ blog.body }}</p>
				<div class="tags mt-2" v-if="blog.tags.length">
					<div v-for="(tag, idx) in blog.tags" :key="idx" class="tag">
						#{{ tag.name }}
					</div>
				</div>
			</div>
		</section>
		<section class="filter-list">
			<RouterLink :to="{ name: 'create-blog' }">
				<button class="btn" style="width: 100%">Create new post</button>
			</RouterLink>
			<hr class="mt-2 mb-2" />
			<div class="input-icon">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					xmlns:xlink="http://www.w3.org/1999/xlink"
					fill="#000000"
					height="18px"
					width="18px"
					version="1.1"
					id="Capa_1"
					viewBox="0 0 488.4 488.4"
					xml:space="preserve"
				>
					<g>
						<g>
							<path
								d="M0,203.25c0,112.1,91.2,203.2,203.2,203.2c51.6,0,98.8-19.4,134.7-51.2l129.5,129.5c2.4,2.4,5.5,3.6,8.7,3.6    s6.3-1.2,8.7-3.6c4.8-4.8,4.8-12.5,0-17.3l-129.6-129.5c31.8-35.9,51.2-83,51.2-134.7c0-112.1-91.2-203.2-203.2-203.2    S0,91.15,0,203.25z M381.9,203.25c0,98.5-80.2,178.7-178.7,178.7s-178.7-80.2-178.7-178.7s80.2-178.7,178.7-178.7    S381.9,104.65,381.9,203.25z"
							/>
						</g>
					</g>
				</svg>
				<input
					type="text"
					placeholder="Search post..."
					v-model="search"
					@input="searchPosts"
				/>
			</div>
			<hr class="mt-2 mb-2" />
			<div class="tags">
				<RouterLink :to="{ name: 'blog' }" class="tag">#all</RouterLink>
				<RouterLink
					:to="{ name: 'tag-blog', params: { slug: tag.slug } }"
					class="tag"
					v-for="tag in tags"
					:key="tag.id"
					>#{{ tag.name }}</RouterLink
				>
			</div>
		</section>
	</section>
</template>
<script>
import { computed, ref } from "vue";
import { fetching } from "../utils";
export default {
	name: "Seidei - Blog",
	props: ["slug"],
	setup(props) {
		const blogs = ref([]);
		const tags = ref([]);
		const search = ref("");

		async function searchPosts(){
			const res = await fetching('get', `posts?search=${search.value}`);
			blogs.value = res.data.posts;
		}

		async function getAllPosts() {
			let res;
			if (props.slug) {
				res = await fetching("get", `tags/${props.slug}`);
			} else {
				res = await fetching("get", "posts");
			}
			blogs.value = res.data.posts;
		}

		async function getAllTags() {
			const res = await fetching("get", "tags");
			tags.value = res.data.tags;
		}

		getAllPosts();
		getAllTags();

		return { blogs, tags, search, searchPosts };
	},
};
</script>
