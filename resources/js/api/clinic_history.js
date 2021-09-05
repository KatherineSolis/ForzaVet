import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/histories',
    method: 'get',
    params: query,
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
