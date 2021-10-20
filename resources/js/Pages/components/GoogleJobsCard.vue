<template>
	<div class="flex flex gap-2 bg-gray-200 rounded-lg p-4 m-2 w-auto items-center">
		<div class="company-logo" v-if="googleJob.company_logo!=null">
			<img class="w-16 h-16 rounded-full" :src="googleJob.company_logo == 'NA' ? 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/450px-No_image_available.svg.png': googleJob.company_logo" alt="logo">
		</div>
		<div class="flex flex-col items-start mt-4 gap-3">
			<h4 class="text-xl font-semibold"><a :href="route('scrapingjob.detail', googleJob.id)">{{googleJob.job_title}}</a></h4>
			<p class="text-sm">{{googleJob.location}}</p>
			<p class="text-sm">{{googleJob.company_name}}</p>
			<a class="p-2 leading-none rounded font-medium mt-3 bg-gray-400 text-xs uppercase" :href="route('scrapingjob.detail', googleJob.id)">Job Detail</a>
		</div>
	</div>
</template>

<script>

export default {
	props: {
		googleJob: Object,
	}

}
</script>

<style>
</style>