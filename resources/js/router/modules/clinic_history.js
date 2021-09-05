import request from '@/utils/request';

export function fetchList() {
  return request({
    url: '/histories',
    method: 'get',
  });
}

export function createHistory(data) {
  return request({
    url: '/history/create',
    method: 'post',
    data,
  });
}

export function updateHistory(data) {
  return request({
    url: '/history/update/' + data.id,
    method: 'post',
    data,
  });
}
