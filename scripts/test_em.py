# You can run this with pytest:
# `cd .../clusterizer/scripts`
# `pip install -U pytest`
# `pytest`
# from there, pytest will run any function with the word "test" in it.
# Print statements are only output if the test fails.

# TODO: Create test for obviously distinct groups 
from pprint import pprint
import em
import numpy as np
from scipy.stats import multivariate_normal
import magic

test_points = [[1.27,50.367,100.4], [2, 60.2, 300], [-5, 74, 534], [7, 0, 470]]
DIST_COUNT = 2
test_distributions = em.init_random_distributions(DIST_COUNT, test_points)


def test_input_to_array():
    arr = em.input_to_array(magic.stri)
    pprint(arr)
    # assert False


def test_em():
    result = em.expectation_maximization(DIST_COUNT, em.input_to_array(magic.stri))
    pprint(result)
    # assert False


# Tests that the algorithm converges to two distinct Gaussians.
def test_em_normals():
    sample1 = multivariate_normal.rvs(mean = (10, 20, 30), cov=10, size=100)
    sample2 = multivariate_normal.rvs(mean = (139, 230, 0), cov=20, size=100)
    total_sample = np.concatenate((sample1, sample2))
    # pprint(total_sample)
    result = em.expectation_maximization(2, total_sample)
    pprint(result)
    assert False


def test_init_dist():
    dists = em.init_random_distributions(3, [[1,50,100], [2, 60, 300], [5, 80, 500], [7, 40, 400]])
    pprint(dists, width=1)
    pprint(test_points)
    # assert False


def test_expectation():
    prob_mtx = em.expectation(test_distributions, test_points)
    pprint(prob_mtx, width = 1)
    assert np.allclose(np.sum(prob_mtx, axis=1), np.ones(prob_mtx.shape[0]))


def test_point_clust_prob():
    pprint(test_points[0])
    pprint(test_distributions[0])
    pprint(test_distributions)
    prob = em.point_cluster_probability(test_points[0], test_distributions[0], test_distributions)
    pprint(prob)
    # assert False


def test_maximization():
    dists = em.maximization(em.expectation(test_distributions, test_points), test_points)
    pprint(dists)
    # assert False


def test_max_mean():
    mean = em.maximize_mean(1 / DIST_COUNT, em.expectation(test_distributions, test_points), 0, test_points)
    pprint(mean)
    # assert False


def test_max_cov():
    mtx = em.expectation(test_distributions, test_points)
    cov = em.maximize_cov(1 / DIST_COUNT, mtx, 0, test_points)
    pprint(cov)
    # assert False