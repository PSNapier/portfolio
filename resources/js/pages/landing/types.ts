export interface ProjectExtraImage {
     src: string;
     alt: string;
}

export interface Project {
     title: string;
     subtitle: string;
     image: string;
     link: string;
     stack: string[];
     description: string;
     ctaText?: string;
     extraImages?: ProjectExtraImage[];
}
