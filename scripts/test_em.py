# TODO: Create test for obviously distinct groups 
from pprint import pprint
import em
import numpy as np

test_points = [[1,50,100], [2, 60, 300], [5, 80, 500], [7, 40, 400]]
test_distributions = em.init_random_distributions(3, test_points)


def test_init_dist():
    dists = em.init_random_distributions(3, [[1,50,100], [2, 60, 300], [5, 80, 500], [7, 40, 400]])
    pprint(dists, width=1)


def test_expectation():
    prob_mtx = em.expectation(test_distributions, test_points)
    pprint(prob_mtx, width = 1)

def test_point_clust_prob():
    prob = em.point_cluster_probability(test_points[0], test_distributions[0], test_distributions)
    pprint(prob)
    # assert False