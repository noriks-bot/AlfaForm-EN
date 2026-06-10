import axios, { AxiosInstance, AxiosRequestConfig } from 'axios';
import { TStatusEnum } from '@/types';
import { setRequestStatus } from '@/helpers';
import { Ref } from 'vue';

const MAX_REQUESTS = window.adtObj?.maxRequests ? Number(window.adtObj.maxRequests) : 8;
const INTERVAL_IN_MS = Math.floor(1000 / MAX_REQUESTS);
let PENDING_REQUESTS = 0;

/**
 * Sets up axios with interceptors for response and error handling.
 *
 * @param {TStatusEnum?} statusRef A Vue Ref object to set the request status.
 * @param {AxiosRequestConfig} config Axios request config.
 * @param {Record<string, any>} options Arbitrary options.
 */
const api = (
  statusRef: Ref<TStatusEnum> | null = null,
  config: AxiosRequestConfig = {},
  options: Record<string, any> = {}
): AxiosInstance => {
  const maxRequests = options.maxRequests || MAX_REQUESTS;
  const intervalInMs = options.intervalInMs || INTERVAL_IN_MS;
  let headers: any = {
    'Content-Type': 'application/json;charset=UTF-8',
    'X-WP-Nonce': window.adtObj.wpNonce,
  };
  if (window.adtObj?.adtObj != null) {
    headers = {
      ...headers,
      Nonce: window.adtObj.wpNonce,
    };
  }
  const axiosInstance = axios.create({
    timeout: 30000,
    responseType: 'json',
    headers,
    baseURL: window.adtObj.restUrl,
    ...config,
  });

  axiosInstance.interceptors.request.use(
    (config) => {
      if (statusRef != null) {
        setRequestStatus(statusRef);
      }

      return new Promise((resolve) => {
        let interval = setInterval(() => {
          if (PENDING_REQUESTS < maxRequests) {
            PENDING_REQUESTS++;
            clearInterval(interval);
            resolve(config);
          }
        }, intervalInMs);
      });
    },
    (error) => {
      if (statusRef != null) {
        setRequestStatus(statusRef, { error: error.response.data });
      }

      return Promise.reject(error);
    }
  );

  axiosInstance.interceptors.response.use(
    (response) => {
      if (statusRef != null) {
        setRequestStatus(statusRef, response);
      }
      PENDING_REQUESTS = Math.max(0, PENDING_REQUESTS - 1);
      return Promise.resolve(response);
    },
    (error) => {
      if (statusRef != null) {
        setRequestStatus(statusRef, { error: error.response.data });
      }

      PENDING_REQUESTS = Math.max(0, PENDING_REQUESTS - 1);
      return Promise.reject({ error: error.response.data });
    }
  );

  return axiosInstance;
};

export default api;
