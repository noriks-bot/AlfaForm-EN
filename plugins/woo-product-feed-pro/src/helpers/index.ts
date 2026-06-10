/**
 * Author: Rymera Web Co
 *
 * @package Svelte_WP_Plugin_Boilerplate
 */

import { isRef, Ref } from 'vue';
import { TStatusEnum } from '@/types';
import purify from 'dompurify';

export enum StatusEnum {
  PENDING = 'pending',
  IDLE = 'idle',
  REJECTED = 'rejected',
  FULFILLED = 'fulfilled',
}

/**
 * Generate a random string.
 *
 * @param {number} length
 */
export const generateRandomId = (length: number = 5): string => {
  length = length < 4 ? 4 : length > 8 ? 8 : length;
  return Math.random()
    .toString(36)
    .substring(2, 2 + length);
};

/**
 * Sets status ref of request to idle after 1 second.
 * @param {Ref<TStatusEnum>} status
 * @param {any} response
 */
export const setRequestStatus = (status: Ref<TStatusEnum>, response: any = null) => {
  if (!isRef(status)) {
    return;
  }

  if (response == null) {
    status.value = StatusEnum.PENDING;
  } else if (response?.data != null) {
    status.value = StatusEnum.FULFILLED;
  } else if (response?.error != null) {
    status.value = StatusEnum.REJECTED;
  }

  setTimeout(() => {
    status.value = StatusEnum.IDLE;
  }, Math.floor((1000 / 3) * 2));
};

/**
 * Helper function to get adtObj from window as it seems, `<template>` doesn't like access to window object.
 */
export const adtObj = () => window.adtObj;

/**
 * Purify HTML string.
 *
 * @param {string} html
 *
 * @since 3.0
 * @return {string}
 */
export const purifyHtml = (html: string) => {
  return purify.sanitize(html, { ALLOWED_TAGS: adtObj().allowedTags, ALLOWED_ATTR: adtObj().allowedAttrs });
};

/**
 * Search for post URLs.
 *
 * @param {string} search
 *
 * @since 3.0
 * @return {Promise<{ label: string; value: string }[]>}
 */
export const apiSearchPostUrls = async (search: string) => {
  const response = await fetch(
    `/wp-json/wp/v2/search?search=${encodeURIComponent(search)}&type=post&subtype=post,page`
  );
  const data = await response.json();
  return data.map((item: any) => ({
    label: item.title,
    value: item.url,
  }));
};

/**
 * Check if the Elite version is active.
 *
 * @return {boolean}
 */
export const isEliteActive = (): boolean => {
  return Boolean(window.adtObj?.isEliteActive);
};

/**
 * Show the Elite upsell modal.
 *
 * @param {string} id
 */
export const showEliteUpsellModal = (id: string): void => {
  if (typeof window.adtObj?.showEliteUpsellModal === 'function') {
    window.adtObj.showEliteUpsellModal(id);
  }
};
