export interface ImageData {
    idProductImage?: number;
    order: number;
    srcLarge: string;
    srcSmall: string;
    alt?: string;
}

export interface ImageSets {
    idProductImageSet?: number;
    originalIndex?: number;
    name: string;
    images: ImageData[];
}

export interface ImageSetNames {
    prop: string;
    name: string;
    images: string;
    order: string;
    urlSmall: string;
    urlLarge: string;
    idProductImageSet: string;
    idProductImage: string;
    originalIndex: string;
}

export interface ImageSetTitles {
    addImageSet: string;
    setName: string;
    deleteImageSet: string;
    imageOrder: string;
    smallImageUrl: string;
    largeImageUrl: string;
    addImage: string;
}

export interface ImageSetError {
    name?: string;
    images: ImageDataError[];
}

export interface ImageDataError {
    order?: string;
    srcLarge?: string;
    srcSmall?: string;
}
