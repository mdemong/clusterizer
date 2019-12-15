# TODO: Create test for obviously distinct groups 
from pprint import pprint
import em

def test_init_dist():
    dists = em.init_random_distributions(5, [[1,50,100], [2, 60, 300], [5, 80, 500]])
    pprint(dists, width=1)
    assert False