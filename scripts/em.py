from scipy.stats import norm
import numpy as np
from pprint import pprint as pprint
# NOTE: To run this code, you may need to run: 
#       `pip install scipy`
#       `pip install numpy` 
#       if you have not already installed numpy and scipy.
# I'm using numpy v1.17

# When using numeric values, it is recommended to use numpy arrays for efficiency. 
# See https://stackoverflow.com/a/994010
# One drawback of this is that we have to explicitly define array size during initialization,
# rather than having dynamically changing array size.


# TODO: define function signature
# This function takes input from PHP and converts it to a convenient format
def read_input():

    
    # Assuming 2 distributions (i.e. binary classification)
    DIST_COUNT = 2
    # TODO: actual data input from PHP
    temp_points = np.array(1, 2, 3);

    expectation_maximization(DIST_COUNT, temp_points)


# Performs the Expectation Maximization algorithm as described in:
# Clustering for malware classification; Pai et al. (2016)
# 
def expectation_maximization(k, temp_points, distributions=[]):
    # Initialize parameters (mean, variance)

    # I'm using standard python lists for distributions, since distributions objects aren't numbers
    if(distributions == []):
        distributions = init_random_distributions(k)

    # Alternate between E and M step until change is negligable
    changed = True
    while(changed):
        # TODO: modify 'changed' based on exp. and max. function outputs
        changed = False

        # E step: Compute probabilities needed in M step, based on
          # current estimates of the distribution parameters
        expectation()

        # M Step: Use the probabilities from the E step to recompute
          # the distribution parameters, based on 
          # maximum likelihood estimators
        maximization()
    return []


def init_random_distributions(count):
    # For now, assuming we can have any float as a mean or SD.

    # TODO: These values are somewhat arbitrary. Do we need to adjust them?
    RANDOM_MEAN_RANGE = 5
    MIN_RANDOM_MEAN = -2.5
    
    MAX_RANDOM_SD = 5
    # Standard deviations are always positive!
    # Setting minimum to epsilon to keep it nonzero 
    # (who knows what that might do...)
    MIN_RANDOM_SD = np.finfo(float).eps

    dists = []
    for i in range(count):
        mean = np.random.default_rng().random()
        mean = (mean * RANDOM_MEAN_RANGE) + MIN_RANDOM_MEAN

        # sd = np.random.default_rng().uniform(MIN_RANDOM_SD, MAX_RANDOM_SD)
        sd = np.random.default_rng().random()
        sd = (sd * MAX_RANDOM_SD) + MIN_RANDOM_SD

        new_dist = norm(mean, sd)
        # TODO: remove these debug print statements
        print("mean:", new_dist.mean())
        print("sd  :", new_dist.std())
        print()
        dists.append(new_dist)
    return dists


# TODO: define function signature
def expectation():
    return


# TODO: define function signature
def maximization():
    return