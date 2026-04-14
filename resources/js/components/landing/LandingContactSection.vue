<script setup lang="ts">
defineProps<{
     selectedColor: string;
     isDark: boolean;
}>();
</script>

<template>
     <section
          class="mt-16 flex w-full justify-center transition-colors"
          :style="{
               backgroundColor: selectedColor,
               color: isDark ? '#171717' : '#fafafa',
          }">
          <div class="content-shell-narrow py-16 text-center">
               <h2
                    class="font-jetbrains-mono color-animate mb-2 text-3xl font-bold transition-colors">
                    Contact Me
               </h2>
               <p class="font-inter color-animate text-lg transition-colors">
                    Interested in comissioning a project or hiring me?<br />Email
                    me your questions and inquiries at
                    <a
                         href="mailto:AbatureStudio@gmail.com?subject=Web%20Dev%20Inquiry"
                         class="color-animate underline underline-offset-2 transition transition-colors hover:opacity-50"
                         :style="{ color: isDark ? '#171717' : '#fafafa' }">
                         AbatureStudio@gmail.com
                    </a>
               </p>
          </div>
     </section>
</template>
