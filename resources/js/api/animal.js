import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/animals',
    method: 'get',
    params: query,
  });
}

export function createAnimal(data) {
  return request({
    url: '/animal/create',
    method: 'post',
    data,
  });
}

export function updateAnimal(data) {
  return request({
    url: '/animal/update/' + data.id,
    method: 'post',
    data,
  });
}
