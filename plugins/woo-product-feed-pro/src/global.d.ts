interface PFPObjInterface {
  pluginDirUrl: string;
  isEliteActive?: boolean;
  showEliteUpsellModal?: (id: string) => void;
  [key: string]: any;
}

declare global {
  interface Window {
    adtObj: PFPObjInterface;
    wp: Record<string, any>;
    ajaxurl: string;
  }

  interface IXHRResponseObj {
    data: ?any;
    error: ?any;
  }
}

window.adtObj = window.adtObj ?? { pluginDirUrl: '' };

/*
 |--------------------------------------------------------------------------
 | Typescript error: TS2669
 |--------------------------------------------------------------------------
 |
 | Following code is just to avoid Typescript error:
 | TS2669: Augmentations for the global scope can only be directly nested in
 | external modules or ambient module declarations.
 |
 */
export {};
