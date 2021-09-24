import request from '@/utils/request';

export function fetchList() {
  return request({
    url: '/dashboard',
    method: 'get',
  });
}

