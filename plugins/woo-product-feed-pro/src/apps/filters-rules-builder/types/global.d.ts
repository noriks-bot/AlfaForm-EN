declare global {
  interface Window {
    adtNonce?: string;
    wp?: {
      i18n?: {
        __?: (text: string, domain?: string) => string;
        _x?: (text: string, context: string, domain?: string) => string;
        sprintf?: (text: string, ...args: any[]) => string;
      };
    };
  }
}

export {};
