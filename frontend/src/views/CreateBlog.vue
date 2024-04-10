<template>
	<form action="" @submit.prevent="submit">
		<h1 class="mb-1">Create new post</h1>

		<div class="alert alert-danger mb-2" v-if="errors.message">
			{{ errors.message }}
			<span class="close" @click="closeAlert">x</span>
		</div>

		<div class="input-box">
			<label for="title">Title</label>
			<input type="text" id="title" v-model="title" />
			<div v-if="errors.title">
				<p
					class="invalid-text"
					v-for="(error, idx) in errors.title"
					:key="idx"
				>
					{{ error }}
				</p>
			</div>
		</div>
		<div class="input-box mt-1">
			<label for="body">Body</label>
			<textarea name="body" id="body" v-model="body"></textarea>
			<div v-if="errors.body">
				<p
					class="invalid-text"
					v-for="(error, idx) in errors.body"
					:key="idx"
				>
					{{ error }}
				</p>
			</div>
		</div>
		<div class="input-box mt-1">
			<label for="tags">Tags</label>
			<input
				type="text"
				id="tags"
				v-model="tag"
				@keydown.ctrl="addTag"
			/>
			<div v-if="errors.body">
				<p
					class="invalid-text"
					v-for="(error, idx) in errors.tags"
					:key="idx"
				>
					{{ error }}
				</p>
			</div>
			<p class="info-text">Ctrl + Enter to add tag</p>

			<!-- show tags -->
			<div class="tags mt-05" v-if="tags.length">
				<div class="tag pointer" :key="idx" v-for="(tag, idx) in tags" @click="removeTag(tag)">
					{{ tag }} (x)
				</div>
			</div>
		</div>
		<button class="btn mt-2">Create post</button>
	</form>
</template>

<script>
import { ref } from "vue";
import { fetching } from "../utils";
import { useRouter } from "vue-router";
import { APP_NAME } from "../config";
import { useStore } from "vuex";
export default {
	name: "Seidei - Login",
	setup() {
		const title = ref("");
		const body = ref("");
		const errors = ref({});
		const router = useRouter();
		const tags = ref([]);
		const tag = ref("");

		function addTag(e) {
			if (tag.value.trim().length && e.key == "Enter") {
				tags.value.push(tag.value);
				tag.value = "";
			}
		}

		function removeTag(tagToRemove){
			tags.value = tags.value.filter(tag => tag != tagToRemove);
		}

		async function submit() {
			const res = await fetching("post", "posts", {
				data: {
					title: title.value,
					body: body.value,
					tags: tags.value
				},
			});
			if (res.status == 422) {
				errors.value = res.data.errors;
				errors.value.message = res.data.message;
			} else if (res.status == 200) {
				router.push({ name: "blog" });
			}
		}

		function closeAlert() {
			errors.value.message = null;
		}

		return {
			title,
			body,
			submit,
			errors,
			closeAlert,
			addTag,
			tags,
			tag,
			removeTag
		};
	},
};
</script>
