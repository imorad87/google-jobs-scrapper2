<template>
	<section class="m-auto">

		<Head title="Scraping Jobs" />

		<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0 m-auto">
			<div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
				<Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
				Dashboard
				</Link>

				<template v-else>
					<Link :href="route('login')" class="text-sm text-gray-700 underline">
					Log in
					</Link>

					<Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
					Register
					</Link>
				</template>
			</div>

			<div class="main-container flex flex-col mb-10 mt-10">
				<div class="controls rounded-lg  p-10 shadow-xl ">
					<p class="text-3xl text-center mb-3">New Scraping Job</p>
					<form @submit.prevent="createJob">
						<div class="form-container flex gap-3 items-center justify-center">
							<label for="keyword">Job Title</label>
							<input type="text" name="keyword" id="keyword" v-model="form.keyword" class="rounded-lg">
							<input type="submit" value="Create" class="bg-gray-400 p-2 border-2 border-opacity-0 hover:border-gray-900 hover:border-opacity-100">
						</div>
					</form>
				</div>
				<hr>
				<div class="jobs-container flex flex-col gap-5 mt-10 shadow-2xl p-10">
					<div class="text-3xl">Scraping Jobs</div>
					<div class="job-items">
						<div class="grid grid-cols-4 items-center justify-center p-10">
							<ScrapingJobCard v-if="scrapingJobs != null" v-for="scrapingJob in scrapingJobs" :scrapingJob="scrapingJob" :key="scrapingJob.id" />
							<p v-else class="text-2xl">No Scraping Jobs Found</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<style scoped>
</style>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import ScrapingJobCard from "@/Pages/components/ScrapingJobCard.vue";
export default defineComponent({
	components: {
		Head,
		Link,
		ScrapingJobCard
	},

	props: {
		canLogin: Boolean,
		canRegister: Boolean,
		laravelVersion: String,
		phpVersion: String,
		scrapingJobs: Object
	},

	data () {
		return {
			form: this.$inertia.form({
				keyword: null,

			}),
		}
	},

	methods: {
		createJob () {
			this.form.post(this.route("scrapingjob.create"));
		}
	}


});



</script>
