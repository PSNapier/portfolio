import type { Project } from './types';

export const projects: Project[] = [
     {
          title: 'ARPG Roller Demos',
          subtitle: 'Interactive tools for equine genetics enthusiasts',
          image: '/imgs/example-breedingroller.png',
          link: 'https://arpg.abature.studio/breeding-roller',
          stack: ['JavaScript', 'CSS'],
          description:
               'Demo project providing examples of automated rollers for ARPG groups and admin, built with JavaScript and CSS for seamless interaction.',
     },
     {
          title: 'Nordanner',
          subtitle:
               'Lorekeeper site with custom  masterlist, crafting, and staff rollers',
          image: '/imgs/example-nordanner.png',
          link: '#',
          ctaText: 'Public site not live yet (in development)',
          stack: ['PHP', 'Laravel', 'Blade', 'Lorekeeper'],
          description:
               'Adds integrated admin Rollers (arena, breeding, cartography) with Lorekeeper-native styling, automated logbook import for over 19,000 characters, advanced search support for custom info fields, lineage/info tab updates on character and MYO pages, and more.',
     },
     {
          title: 'Critterverse',
          subtitle: 'Rollers for the Critterverse ARPG',
          image: '/imgs/example-critterverse.png',
          link: 'https://critterverse.abature.studio/',
          stack: ['JavaScript', 'HTML', 'Tailwind'],
          description:
               'Tabbed interface for breeding rolls (sire/dam, mutations, items) and a separate randomizer, with results rendered in-page. JavaScript with Tailwind CSS.',
     },
     {
          title: 'Rattlesnake Mountain',
          subtitle: 'Custom ARPG site',
          image: '/imgs/example-rattlesnakemountain.png',
          link: '#',
          ctaText: 'Public site not live yet (in development)',
          extraImages: [
               {
                    src: '/imgs/example-rattlesnakemountain-1.png',
                    alt: 'Rattlesnake Mountain admin panel — CMS menu and pages',
               },
               {
                    src: '/imgs/example-rattlesnakemountain-2.png',
                    alt: 'Rattlesnake Mountain shop — item grid after data import',
               },
          ],
          stack: ['Laravel', 'Vue', 'Tailwind'],
          description:
               'Custom HARPG site. Laravel, Vue 3 with Inertia, Tailwind, and MySQL. Full user account system with character creation, image upload, interactive rollers, and much more! Standout work includes a deep, fully tailored admin panel and a pipeline that automatically imports the prior site’s shop data so inventory and history carry over cleanly.',
     },
     {
          title: 'Sigil Maker',
          subtitle: 'Automated sigil crafting',
          image: '/imgs/example-sigilmaker.png',
          link: 'https://sigilmaker.abature.studio/',
          stack: ['JavaScript', 'HTML', 'Canvas'],
          description:
               'Tool that turns typed text into a digit string using a fixed letter-to-digit table, with an optional step that strips duplicate digits. The canvas places digits 0–9 on a circle and draws line segments in order so the path reads like a classic sigil construction.',
     },
];
