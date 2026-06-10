const utility = {

  /**
   * Hack used to enable the Update button.
   *
   * This function make use of the editPost() action to modify a non existing meta data with the purpose of activating
   * the "Update" button.
   *
   * Ref:
   *
   * https://wordpress.org/gutenberg/handbook/designers-developers/developers/data/data-core-editor/#editpost
   * https://wordpress.org/gutenberg/handbook/designers-developers/developers/backward-compatibility/meta-box/
   */
  activateUpdateButton: function(){

    wp.data.dispatch('core/editor').editPost({meta: {_non_existing_meta: true}});

  }

};

export default utility;